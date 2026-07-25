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
use Illuminate\Support\Facades\Session;

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
    public function index(Request $request)
    {
        $semesterActive = Semester::getActive();
        $semesterList = Semester::whereNull('deleted_at')->orderBy('id', 'desc')->get();

        $semesterId = $request->input('semester_id', $semesterActive->id);
        $selectedSemester = Semester::find($semesterId);
        if (!$selectedSemester) {
            $selectedSemester = $semesterActive;
            $semesterId = $semesterActive->id;
        }

        $data['semester_list'] = $semesterList;
        $data['selected_semester_id'] = $semesterId;

        // --- KPI Summary ---
        $halaqohQuery = Halaqoh::where('semester_id', $semesterId);
        $data['count_halaqoh']  = $halaqohQuery->count();
        $data['count_pengajar'] = (clone $halaqohQuery)->distinct('pengajar_id')->count('pengajar_id');
        $data['count_program']  = (clone $halaqohQuery)->distinct('program_id')->count('program_id');
        $data['count_santri']   = \App\Model\View\ViewPeserta::where('semester_id', $semesterId)->count();
        $data['rasio_santri_pengajar'] = $data['count_pengajar'] > 0
            ? round($data['count_santri'] / $data['count_pengajar'], 1) : 0;

        // --- Semester Trend (last 8 semesters) ---
        $semesters = Semester::whereNull('deleted_at')->orderBy('id', 'desc')->limit(8)->get()->reverse()->values();
        $semesterIds = $semesters->pluck('id');
        $trendData = DB::table('view_peserta')
            ->selectRaw('semester_id, COUNT(DISTINCT peserta_id) as total_santri')
            ->whereIn('semester_id', $semesterIds)
            ->groupBy('semester_id')
            ->pluck('total_santri', 'semester_id');
        $trendHalaqoh = DB::table('view_halaqoh')
            ->selectRaw('semester_id, COUNT(DISTINCT halaqoh_id) as total_halaqoh, COUNT(DISTINCT pengajar_id) as total_pengajar')
            ->whereIn('semester_id', $semesterIds)
            ->groupBy('semester_id')
            ->get()
            ->keyBy('semester_id');

        $data['trend'] = $semesters->map(function ($s) use ($trendData, $trendHalaqoh) {
            $h = $trendHalaqoh->get($s->id);
            return [
                'semester'  => 'Sem ' . $s->name,
                'santri'    => $trendData->get($s->id, 0),
                'halaqoh'   => $h ? $h->total_halaqoh : 0,
                'pengajar'  => $h ? $h->total_pengajar : 0,
            ];
        })->values();

        // --- Program Distribution (active semester) ---
        $data['program_dist'] = DB::table('view_peserta')
            ->selectRaw('program_name, program_id, COUNT(DISTINCT peserta_id) as total_santri, COUNT(DISTINCT halaqoh_id) as total_halaqoh')
            ->where('semester_id', $semesterId)
            ->groupBy('program_name', 'program_id')
            ->orderBy('program_id')
            ->get();

        // --- Gender Distribution ---
        $data['gender_dist'] = DB::table('view_peserta')
            ->selectRaw("CASE WHEN gender_santri = 'MALE' THEN 'Ikhwan' WHEN gender_santri = 'FEMALE' THEN 'Akhwat' ELSE 'Belum Diisi' END as label, COUNT(1) as total")
            ->where('semester_id', $semesterId)
            ->groupBy('gender_santri')
            ->get();

        // --- Age Distribution ---
        $data['age_dist'] = DB::table('view_peserta')
            ->join('santri', 'santri.id', '=', 'view_peserta.santri_id')
            ->where('view_peserta.semester_id', $semesterId)
            ->selectRaw("
                CASE
                    WHEN TIMESTAMPDIFF(YEAR, santri.birth_date, CURDATE()) < 10 THEN '< 10 th'
                    WHEN TIMESTAMPDIFF(YEAR, santri.birth_date, CURDATE()) BETWEEN 10 AND 15 THEN '10-15 th'
                    WHEN TIMESTAMPDIFF(YEAR, santri.birth_date, CURDATE()) BETWEEN 16 AND 20 THEN '16-20 th'
                    WHEN TIMESTAMPDIFF(YEAR, santri.birth_date, CURDATE()) BETWEEN 21 AND 30 THEN '21-30 th'
                    WHEN TIMESTAMPDIFF(YEAR, santri.birth_date, CURDATE()) BETWEEN 31 AND 40 THEN '31-40 th'
                    WHEN TIMESTAMPDIFF(YEAR, santri.birth_date, CURDATE()) BETWEEN 41 AND 50 THEN '41-50 th'
                    WHEN TIMESTAMPDIFF(YEAR, santri.birth_date, CURDATE()) > 50 THEN '> 50 th'
                    ELSE 'N/A'
                END as age_range,
                COUNT(1) as total
            ")
            ->groupBy('age_range')
            ->orderByRaw("FIELD(age_range, '< 10 th','10-15 th','16-20 th','21-30 th','31-40 th','41-50 th','> 50 th','N/A')")
            ->get();

        // --- KBM Activity ---
        $kbmStats = DB::table('activity_report')
            ->join('halaqoh', 'halaqoh.id', '=', 'activity_report.halaqoh_id')
            ->where('halaqoh.semester_id', $semesterId)
            ->selectRaw('COUNT(1) as total_kbm, COUNT(DISTINCT activity_report.halaqoh_id) as halaqoh_aktif')
            ->first();
        $data['kbm_total'] = $kbmStats->total_kbm ?? 0;
        $data['kbm_halaqoh_aktif'] = $kbmStats->halaqoh_aktif ?? 0;
        $data['kbm_coverage'] = $data['count_halaqoh'] > 0
            ? round(($data['kbm_halaqoh_aktif'] / $data['count_halaqoh']) * 100) : 0;

        // --- Daftar Ulang Progress ---
        $duStats = DB::table('daftar_ulang')
            ->join('peserta', 'peserta.id', '=', 'daftar_ulang.peserta_id')
            ->join('halaqoh', 'halaqoh.id', '=', 'peserta.halaqoh_id')
            ->where('halaqoh.semester_id', $semesterId)
            ->whereNull('daftar_ulang.deleted_at')
            ->selectRaw('COUNT(1) as total, SUM(CASE WHEN daftar_ulang.verified_at IS NOT NULL THEN 1 ELSE 0 END) as verified')
            ->first();
        $data['du_total'] = $duStats->total ?? 0;
        $data['du_verified'] = $duStats->verified ?? 0;
        $data['du_pending'] = $data['du_total'] - $data['du_verified'];
        $data['du_percent'] = $data['du_total'] > 0
            ? round(($data['du_verified'] / $data['du_total']) * 100) : 0;

        // --- Day Distribution ---
        $data['day_dist'] = DB::table('view_halaqoh')
            ->selectRaw("day, COUNT(DISTINCT halaqoh_id) as total_halaqoh, (SELECT COUNT(1) FROM view_peserta vp WHERE vp.semester_id = view_halaqoh.semester_id AND vp.day = view_halaqoh.day) as total_santri")
            ->where('semester_id', $semesterId)
            ->groupBy('semester_id', 'day')
            ->get();

        $data['semester_active'] = $selectedSemester;

        return view('home')->with('data', (Object) $data);
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
        $semesterId = $request->input('semester_id');
        $semester = null;

        if (empty($semesterId)) {
            $semester = Semester::getActive();
            $semesterId = $semester->id;
        } else {
            $semester = Semester::find($semesterId);
            if (!$semester) {
                return redirect()->route('rekap.nilai')->with('alert', ['message'=> "Data untuk Semester $semesterId tidak ditemukan!", 'type'=>'danger']);
            }
        }

        $data['semester'] = $semester;
        $data['list'] = \App\Model\View\ViewPeserta::where('semester_id', $semesterId)
            ->orderBy('pengajar_name', 'asc')->with('daftarUlang')->orderBy('santri_name','asc')->get();
        $data['days'] = explode(",", strtoupper(env('AVAILABLE_DAYS', 'SABTU,AHAD')));

        return view('pages.report.rekap_nilai',$data);
    }

    public function exportRekapNilai(Request $request)
    {
        $semesterId = $request->input('semester_id');
        $semester = null;

        if (empty($semesterId)) {
            $semester = Semester::getActive();
            $semesterId = $semester->id;
        } else {
            $semester = Semester::find($semesterId);
            if (!$semester) {
                return redirect()->back()->with('alert', ['message'=> "Data Semester tidak ditemukan!", 'type'=>'danger']);
            }
        }

        return (new RekapNilaiExport)->forSemester($semesterId)->download('rekap-nilai-'.$semester->name.'-'.date('Ymd_Hi').'.xlsx');
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

    public function rekapKehadiran(Request $request)
    {
        $semesterActive = Session::get('semesterActive');
        $semesterId = empty($request->semester_id) ? $semesterActive->id : $request->semester_id;
        $data['kehadiran'] = Attendance::selectRaw('peserta_id, COUNT(1) count_kehadiran')
            ->with('peserta')
            ->whereIn('peserta_id', function ($query) use ($semesterId) {
                $query->select('peserta_id')->from('view_peserta')->where('semester_id', $semesterId);
            })
            ->where('status', 1)
            ->groupBy('peserta_id')
            ->orderBy('count_kehadiran', 'desc')
            ->get();

        // TODO bikin view untuk kehadiran

        return view('pages.report.rekap_kehadiran',$data);
    }

}
