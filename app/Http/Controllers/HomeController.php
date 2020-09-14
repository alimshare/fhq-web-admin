<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use \App\Model\Peserta;
use \App\Model\Semester;

class HomeController extends Controller
{
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
        $data['count_halaqoh']  = \App\Model\Halaqoh::count();
        $data['count_pengajar'] = \App\Model\Pengajar::count();
        $data['count_santri']   = \App\Model\Santri::count();
        $data['count_program']  = \App\Model\Program::count();

        $SQL = "SELECT program_name, halaqoh, ( SELECT COUNT(1) AS peserta FROM view_peserta WHERE program_id = T1.program_id) AS peserta
                FROM (
                    SELECT program_id, program_name, SUM(1) AS halaqoh FROM view_halaqoh
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
        // dd('aaa');

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
        $halaqoh = \App\Model\View\ViewHalaqoh::where('pengajar_id', $user->profile->id)->WithCount(['peserta'])->get();

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

        return view('pages.profile.profile_edit',$data);
    }
}
