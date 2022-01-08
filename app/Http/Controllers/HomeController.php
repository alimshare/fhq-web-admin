<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use \App\Model\Peserta;
use \App\Model\Semester;
use \App\Model\Halaqoh;
use \App\Model\ActivityReport;
use \App\Model\Attendance;
use \App\Exports\RekapNilaiExport;
use Excel;


class HomeController extends Controller
{
    private $data = [];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $semesterActive = Semester::getActive();
        $halaqoh = Halaqoh::where('semester_id', $semesterActive->id);

        $data['count_halaqoh']  = $halaqoh->count();
        $data['count_pengajar'] = $halaqoh->distinct('pengajar_id')->count('pengajar_id');
        $data['count_program']  = $halaqoh->count('program_id');
        $data['count_santri']   = \App\Model\View\ViewPeserta::where('semester_id', $semesterActive->id)->count();

        $SQL = "SELECT program_name, halaqoh, ( SELECT COUNT(1) AS peserta FROM view_peserta WHERE semester_id = '".$semesterActive->id."' AND program_id = T1.program_id) AS peserta
                FROM (
                    SELECT program_id, program_name, SUM(1) AS halaqoh FROM view_halaqoh
                    WHERE semester_id = '". $semesterActive->id ."'
                    GROUP BY program_id, program_name
                ) T1";
        $countPeserta = DB::select($SQL); // sementara pake native query

        $colorList = array('#F7464A', '#46BFBD', '#FDB45C', '#0097a7', '#d84315', '#6d4c41','#283593', '#c2185b', '#00695c', '#9e9d24', '#01579b','#6a1b9a' ,'#ec407a', '#ea80fc');
        for ($i=0; $i < count($countPeserta); $i++) { 
            $colorIndex = array_rand($colorList, 1);
            $countPeserta[$i]->color = $colorList[$colorIndex];
            unset($colorList[$colorIndex]);
        }

        $data['count_peserta']  = $countPeserta;
        
        return view('home')->with('data', (Object) $data);
    }

    /**
     * Show the change password form
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function changePassword()
    {
        return view('pages.change-password');
    }

    public function changePasswordProcess(Request $req)
    { 
        
        $validatedData = $req->validate([
            'old_password'  => 'required',
            'new_password'  => 'required|min:6|same:confirm_password'
        ]);

        if (Hash::check($req->input('old_password'), auth()->user()->password)) {
            $currentUser = \App\User::find(auth()->user()->id);
            $currentUser->password = Hash::make($req->input('new_password'));
            if ($currentUser->save()){
                return redirect('/change-password')->with('alert', ['message'=>'Change password success, please re-login to application using your new password !', 'type'=>'success']);    
            } else {
                return redirect('/change-password')->with('alert', ['message'=>'Change password fail', 'type'=>'danger']);
            }

        } else {            
            return redirect('/change-password')->with('alert', ['message'=>'Your current password invalid !', 'type'=>'danger']);
        }
    }

    public function profile(Request $request)
    {
        $userId = auth()->user()->id;
        $user = \App\User::where('id', $userId)->with(['profile','roles'])->first();
        $halaqoh = \App\Model\View\ViewHalaqoh::where('pengajar_id', $user->profile->id)->WithCount(['peserta'])->orderBy('halaqoh_id', 'desc')->get();

        $halaqohAktif = [];
        $halaqohLampau = [];
        foreach ($halaqoh as $row) {
            if ($row->semester_id == Semester::getActive()->id) {
                $halaqohAktif[] = $row;
            } else {
                $halaqohLampau[] = $row;
            }            
        }

        $data['profile']        = $user->profile;
        $data['roles']          = $user->roles->pluck('name')->toArray();
        $data['halaqoh_aktif']  = $halaqohAktif;
        $data['halaqoh_lampau'] = $halaqohLampau;

        return view('pages.profile.profile',$data);
    }

    public function profile_edit(Request $request)
    {
        $userId = auth()->user()->id;
        $user = \App\User::where('id', $userId)->with(['profile','roles'])->first();

        $data['profile']        = $user->profile;
        $data['roles']          = $user->roles->pluck('name')->toArray();
        $data['lookup']['marital_status'] = HomeController::MaritalStatus_Lookup();
        $data['lookup']['educational_background'] = HomeController::EducationalBackground_Lookup();

        return view('pages.profile.profile_edit',$data);
    }

    public function profile_edit_save(Request $request)
    {
        $profileType = $request->profile_type;
        $profileID = $request->profile_id;


        $updateData = $request->only([
            'name','father_name','birth_place',
            'birth_date','phone','email','marital_status','spouse',
            'address','city','district','village','educational_background',
            'educational_field','occupation'
        ]);

        $profile = $profileType::find($profileID);
        foreach ($updateData as $field => $value) {
            $profile->$field = $value;
        }

        if ($profile->save()){
            return redirect()->route('profile');
        }
        return redirect()->back();
    }

    public function rekapNilai(Request $request)
    {
        $data['list'] = \App\Model\View\ViewPeserta::where('semester_id', Semester::getActive()->id)
            ->orderBy('pengajar_name', 'asc')->orderBy('santri_name','asc')->get();
        return view('pages.report.rekap_nilai',$data);
    }

    public function exportRekapNilai(Request $request)
    {
        $semester = Semester::getActive();
        return (new RekapNilaiExport)->forSemester($semester->id)->download('rekap-nilai-'.$semester->name.'-'.date('Ymd_Hi').'.xlsx');
    }

    public static function MaritalStatus_Lookup(){
        return [
            ['name' => 'Lajang', 'value' => '1'],
            ['name' => 'Menikah', 'value' => '2'],
            ['name' => 'Janda/Duda', 'value' => '3']
        ];
    }

    public static function EducationalBackground_Lookup(){
        return [
            ['name' => 'SMP', 'value' => 'SMP'],
            ['name' => 'SMA/SMK', 'value' => 'SMA/SMK'],
            ['name' => 'D1/D2', 'value' => 'D1/D2'],
            ['name' => 'D3', 'value' => 'D3'],
            ['name' => 'S1/D4', 'value' => 'S1/D4'],
            ['name' => 'S2', 'value' => 'S2'],
            ['name' => 'S3', 'value' => 'S3']
        ];
    }

    public function clearCache($key = null) {
        if ($key) {
            Cache::forget($key);
            dd("forget cache key : ". $key);
        } else {
            Cache::flush();
            dd("cache flush");
        }
    }

    public function rekapKBM(Request $request)
    {
        $semesterActive = \App\Model\Semester::getActive();
        $data['kbm']    = ActivityReport::whereIn('halaqoh_id', function ($query) use ($semesterActive) {
                $query->select('id')->from('halaqoh')->where('semester_id', $semesterActive->id);
            })
            ->with('halaqoh')
            ->withCount(['attendances', 'hadir'])
            ->orderBy('tgl', 'desc')
            ->get();

        
        // TODO bikin view untuk kbm

        return view('pages.report.rekap_kbm',$data);
    }

    public function rekapKehadiran(Request $request)
    {
        $semesterActive = \App\Model\Semester::getActive();
        $data['kehadiran'] = Attendance::selectRaw('peserta_id, COUNT(1) count_kehadiran')
            ->with('peserta')
            ->whereIn('peserta_id', function ($query) use ($semesterActive) {
                $query->select('peserta_id')->from('view_peserta')->where('semester_id', $semesterActive->id);
            })
            ->where('status', 1)
            ->groupBy('peserta_id')
            ->orderBy('count_kehadiran', 'desc')
            ->get();

        // TODO bikin view untuk kehadiran

        return view('pages.report.rekap_kehadiran',$data);
    }

}
