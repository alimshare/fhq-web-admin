<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use DB;
use App\Model\{Semester, Halaqoh};

class HalaqohController extends Controller
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
     * Global variable
     */
    public $data = array();

    /**
     * Get all lists reference by semester
     */
    public function lists(Request $request, $reference=null)
    {
        # cache for a hour
        $this->data['list'] = Cache::remember('viewHalaqoh.all', 60*60*24, function () {
            return \App\Model\View\ViewHalaqoh::all();
        });

        # cache for a hour
        $this->data['peserta']      = Cache::remember('viewPeserta.all', 60*60*24, function () {
            return \App\Model\View\ViewPeserta::all();
        });

        return view('pages.halaqoh.list', $this->data);
    }

    /**
     * Add halaqoh, show a new form
     */
    public function add(Request $request)
    {
    	$this->data['program']  = \App\Model\Program::orderBy('name','asc')->get();
        $this->data['pengajar'] = \App\Model\Pengajar::orderBy('name','asc')->get();
        
        $this->data['hari']       = $request->get('hari');
        $this->data['program_id'] = $request->get('program');
        $this->data['redirectTo'] = $request->get('ref');

    	return view('pages.halaqoh.form-add', $this->data);
    }

    /**
     * Save/update halaqoh
     */
    public function save(Request $request )
    {        
        $hari           = $request->day;
        $program_id     = $request->program;
        $pengajar_id    = $request->pengajar;
        $semester_id    = Semester::getActive()->id;
        $redirectTo     = !empty($request->redirectTo) ? $request->redirectTo : '/halaqoh/add';

        $halaqoh = Halaqoh::where('semester_id', $semester_id)
            ->where('pengajar_id', $pengajar_id)
            ->where('program_id', $program_id)
            ->where('day', $hari)
            ->first();
            
        if (!is_null($halaqoh)) {
            return redirect($redirectTo)
                ->with('alert', ['message'=>"Halaqoh sudah tersedia!", 'type'=>'danger']);
        }

        $halaqoh = new Halaqoh;
        $halaqoh->day           = $hari;
        $halaqoh->program_id    = $program_id;
        $halaqoh->pengajar_id   = $pengajar_id;
        $halaqoh->semester_id   = $semester_id;
        $halaqoh->start_hour    = '07:00';
        $halaqoh->created_at    = date('Y-m-d H:i:s');

        if ($halaqoh->save()){
            $halaqoh->reference = $halaqoh->id;
            $halaqoh->save();

            return redirect($redirectTo)->with('alert', ['message'=>"Halaqoh berhasil dibuat", 'type'=>'success']);
        } else {
            return redirect($redirectTo)->with('alert', ['message'=>"Menambahkan peserta ke halaqoh gagal dilakukan", 'type'=>'danger']);
        }

    }

    /**
     * Detail halaqoh
     */
    public function detail(Request $request, $reference=null)
    {

        $this->data['halaqoh'] = \App\Model\View\ViewHalaqoh::where('halaqoh_reference', $reference)->first();
        $this->data['peserta'] = \App\Model\View\ViewPeserta::where('halaqoh_reference', $reference)->get();

    	// dd($this->data);
    	return view('pages.halaqoh.form', $this->data);
    }

    public function editDetail(Request $request, $reference=null)
    {

        $this->data['halaqoh'] = \App\Model\View\ViewHalaqoh::where('halaqoh_reference', $reference)->first();
        $this->data['peserta'] = \App\Model\View\ViewPeserta::where('halaqoh_reference', $reference)->get();

        // dd($this->data);
        return view('pages.halaqoh.form-edit', $this->data);
    }

    public function saveDetail(Request $request)
    {
        $halaqohReference = $request->halaqohReference;
        // dd($request->all());
        foreach ($request->data as $pesertaId => $nilai) {
            $peserta = \App\Model\Peserta::find($pesertaId);
            if ($peserta != null) {
                $peserta->nilai_uts_teori = $nilai['nilai_uts_teori'];
                $peserta->nilai_uts_praktek = $nilai['nilai_uts_praktek'];
                $peserta->nilai_uas_teori = $nilai['nilai_uas_teori'];
                $peserta->nilai_uas_praktek = $nilai['nilai_uas_praktek'];
                $peserta->khatam = $nilai['khatam'];
                $peserta->kehadiran = $nilai['kehadiran'];
                $peserta->status = $nilai['status'];
                $peserta->note = $nilai['note'];
                $peserta->save();
            }
        }
        
        return redirect("/halaqoh/{$halaqohReference}");
    }

    /**
     * Remove halaqoh
     */
    public function remove(Request $request)
    {
    	// dd($request->all());
    	$reference = $request->input('halaqoh_reference');
    	$with_data = [];


    	$this->data['halaqoh'] = $this->hit_api("halaqoh/remove/{$reference}", "delete", $with_data);
    	return redirect(url()->previous());
    }

    public function viewRaport(Request $request, $peserta_id = null)
    {
        $peserta = \App\Model\View\ViewPeserta::where('peserta_id', $peserta_id)->first();
        if (!$peserta) {
            return redirect()->back();
        }

        $templateName = $this->get_template($peserta->program_name);
        $template = new \PhpOffice\PhpWord\TemplateProcessor(storage_path($templateName));
        
        $template->setValue('santri_name', $peserta->santri_name);
        $template->setValue('nis', $peserta->nis);
        $template->setValue('program_name', $peserta->program_name);
        $template->setValue('semester_name', $peserta->semester_name);
        
        if ($peserta->program_name == "TAKHASSUS") {
            $template->setValue('nilai_uts_praktek', $peserta->nilai_uts_teori);
            $template->setValue('nilai_uts_praktek_text', $this->terbilang($peserta->nilai_uts_teori));
            $template->setValue('nilai_uts_teori', "");
            $template->setValue('nilai_uts_teori_text', "");
            $template->setValue('nilai_uts_tahfizh', $peserta->nilai_uts_praktek);
            $template->setValue('nilai_uts_tahfizh_text', $this->terbilang($peserta->nilai_uts_praktek));
    
            $template->setValue('nilai_uas_praktek', $peserta->nilai_uas_teori);
            $template->setValue('nilai_uas_praktek_text', $this->terbilang($peserta->nilai_uas_teori));
            $template->setValue('nilai_uas_teori', "");
            $template->setValue('nilai_uas_teori_text', "");
            $template->setValue('nilai_uas_tahfizh', $peserta->nilai_uas_praktek);
            $template->setValue('nilai_uas_tahfizh_text', $this->terbilang($peserta->nilai_uas_praktek));
        } else {
            $template->setValue('nilai_uts_praktek', $peserta->nilai_uts_praktek);
            $template->setValue('nilai_uts_teori', $peserta->nilai_uts_teori);
            $template->setValue('nilai_uts_praktek_text', $this->terbilang($peserta->nilai_uts_praktek));
            $template->setValue('nilai_uts_teori_text', $this->terbilang($peserta->nilai_uts_teori));
            $template->setValue('nilai_uts_tahfizh', "");
            $template->setValue('nilai_uts_tahfizh_text', "");
    
            $template->setValue('nilai_uas_praktek', $peserta->nilai_uas_praktek);
            $template->setValue('nilai_uas_teori', $peserta->nilai_uas_teori);
            $template->setValue('nilai_uas_praktek_text', $this->terbilang($peserta->nilai_uas_praktek));
            $template->setValue('nilai_uas_teori_text', $this->terbilang($peserta->nilai_uas_teori));
            $template->setValue('nilai_uas_tahfizh', "");
            $template->setValue('nilai_uas_tahfizh_text', "");
        }

        $template->setValue('kehadiran', $peserta->kehadiran ?? 0);
        $template->setValue('kehadiran_grade', $kehadiranGrade = $this->get_grade_kehadiran($peserta->kehadiran));
        $template->setValue('kehadiran_text', $this->get_grade_description($kehadiranGrade));
        
        $template->setValue('khatam', $peserta->khatam ?? 0);
        $template->setValue('khatam_grade', $khatamGrade = $this->get_grade_khatam($peserta->program_name, $peserta->khatam, $peserta->gender));
        $template->setValue('khatam_text', $this->get_grade_description($khatamGrade));
        
        $template->setValue('catatan', $peserta->catatan);
        $template->setValue('status', $peserta->status ?? 'Mengulang');
        $template->setValue('pengajar_name', $peserta->pengajar_name);
        $template->setValue('program_next', $this->get_next_program($peserta->program_name, $peserta->status));
        $currentDate = date('d').' '.$this->get_month_description(date('m')). ' '. date('Y');
        $template->setValue('date', $currentDate);

        $filename = 'rapor_'.$peserta->santri_name.'_'.$peserta->semester_name.'.docx';

        $pathToFile = storage_path('export/'.$filename);
        $template->saveAs($pathToFile);

        return response()->download($pathToFile)->deleteFileAfterSend(true);
    }

    function get_template($program) {
        return ($program == "TAHFIDZ") ? 'template/template_rapor_tahfidz.docx' : 'template/template_rapor_tahsin.docx';
    }

    function get_month_description($monthIndex){
        $months = [
            'Januari', 'Februari','Maret','April',
            'Mei','Juni','Juli','Agustus',
            'September','Oktober','November','Desember'
        ];
        return $months[$monthIndex-1];
    }

    function get_grade_description($grade = "") {
        switch ($grade) {
            case 'B': return "Baik";
            case 'C': return "Cukup";
            case 'K': return "Kurang";
            default: return "";
        }
    }

    function get_grade_kehadiran($kehadiran = 0) {
        if ($kehadiran > 16) {
            return "B";
        } else if ($kehadiran >= 15) {
            return "C";
        } else {
            return "K";
        }
    }

    function get_grade_khatam($program = "", $khatam = 0, $gender="MALE") {
        $minKhatamIkhwan = 0;
        $minKhatamAkhwat = 0;

        if ($program == "PRA TAHSIN") {
            $minKhatamIkhwan = 0;
            $minKhatamAkhwat = 0;
        } else if ($program == "TAHSIN 1") {
            $minKhatamIkhwan = 2;
            $minKhatamAkhwat = 1;
        } else if ($program == "TAHSIN 2") {
            $minKhatamIkhwan = 4;
            $minKhatamAkhwat = 3;
        } else if ($program == "TAKHASSUS") {
            $minKhatamIkhwan = 5;
            $minKhatamAkhwat = 4;
        }

        return $this->get_grade_khatam_by_gender($gender, $khatam, $minKhatamIkhwan, $minKhatamAkhwat);
    }

    function get_grade_khatam_by_gender($gender, $khatam, $minimumKhatamIkhwan, $minimumKhatamAkhwat) {
        $minimumKhatam = ($gender == "MALE") ? $minimumKhatamIkhwan : $minimumKhatamAkhwat;

        if ($khatam > $minimumKhatam) {
            return "B";
        } else if ($khatam == $minimumKhatam) {
            return "C";
        } else {
            return "K";
        }
    }

    function get_next_program($currentProgram = "", $status = "TETAP") {
        if ($status == "TETAP" || empty($status)) return $currentProgram;

        switch (trim($currentProgram)) {
            case 'PRA TAHSIN': return 'TAHSIN 1';
            case 'TAHSIN 1': return 'TAHSIN 2';
            case 'TAHSIN 2': return 'TAKHASSUS';
            case 'TAKHASSUS': return 'TAHFIDZ';
            case 'TAHFIDZ': return 'TAHFIDZ';
            case 'TADARUS': return 'TADARUS';
            case 'BAGHDADIYAH A': return 'BAGHDADIYAH B';
            case 'BAGHDADIYAH B': return 'TAHSIN A';
            case 'TAHSIN A': return 'TAHSIN B';
            case 'TAHSIN B': return 'TAHFIDZ ANAK';
            case 'TAHFIDZ ANAK': return 'TAHFIDZ ANAK';
            case 'BAHASA ARAB': return 'BAHASA ARAB';

            default: return "";
        }
    }
    
    function terbilang($nilai) {
        if($nilai<0) {
            $hasil = "minus ". trim($this->penyebut($nilai));
        } else {
            $hasil = trim($this->penyebut($nilai));
        }   
        
        if ($this->is_decimal($nilai)) {
            $explode = explode(".", $nilai);
            $hasil .= " koma " .trim($this->penyebut($explode[1]));
        }
        
        return $hasil;
    }

    function penyebut($nilai) {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " ". $huruf[$nilai];
        } else if ($nilai <20) {
            $temp = $this->penyebut($nilai - 10). " belas";
        } else if ($nilai < 100) {
            $temp = $this->penyebut($nilai/10)." puluh". $this->penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . $this->penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->penyebut($nilai/100) . " ratus" . $this->penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . $this->penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->penyebut($nilai/1000) . " ribu" . $this->penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->penyebut($nilai/1000000) . " juta" . $this->penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = $this->penyebut($nilai/1000000000) . " milyar" . $this->penyebut(fmod($nilai,1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = $this->penyebut($nilai/1000000000000) . " trilyun" . $this->penyebut(fmod($nilai,1000000000000));
        }

        return $temp;
    }

    function is_decimal( $val )
    {
        return is_numeric( $val ) && floor( $val ) != $val;
    }

    function pindah($halaqohId = null, $pesertaId = null)
    {
        $this->data['currentHalaqoh'] = '';
        $semesterActive = \App\Model\Semester::getActive();
        $this->data['halaqoh'] = \App\Model\View\ViewHalaqoh::where('semester_id', $semesterActive->id)->orderBy('pengajar_name')->get();

        if (!empty($halaqohId)) {
            $this->data['peserta'] = \App\Model\View\ViewPeserta::where('halaqoh_id', $halaqohId)->get();
            $this->data['currentHalaqoh'] = $halaqohId;
        }


        return view('pages.halaqoh.form-pindah', $this->data);
    }

    function pindahPost(Request $request)
    {
        $halaqohAwal = \App\Model\View\ViewHalaqoh::where('halaqoh_id', $request->old_halaqoh)->first();
        if (!$halaqohAwal) {
            return redirect('/halaqoh/pindah')->with('alert', ['message'=>"Halaqoh Awal tidak valid", 'type'=>'warning']);
        }

        $halaqohTujuan = \App\Model\View\ViewHalaqoh::where('halaqoh_id', $request->new_halaqoh)->first();
        if (!$halaqohTujuan) {
            return redirect('/halaqoh/pindah')->with('alert', ['message'=>"Halaqoh Tujuan tidak ditemukan", 'type'=>'warning']);
        }

        $peserta = \App\Model\Peserta::where('id', $request->peserta)->first();
        $santri = $peserta->getSantri();
        $peserta->halaqoh_id = $request->new_halaqoh;
        if ($peserta->save()){
            return redirect('/halaqoh/pindah')->with('alert', ['message'=>"Santri <b>$santri->name</b> berhasil dipindahkan ke halaqoh  :  <em>$halaqohTujuan->pengajar_name ($halaqohTujuan->program_name)</em> ", 'type'=>'success']);
        } else {
            return redirect('/halaqoh/pindah')->with('alert', ['message'=>"Pindah Halaqoh gagal dilakukan", 'type'=>'danger']);
        }
    }

    function addPeserta($halaqohId = null)
    {

        $semesterActive = \App\Model\Semester::getActive();
        $this->data['halaqoh'] = \App\Model\View\ViewHalaqoh::where('semester_id', $semesterActive->id)->orderBy('pengajar_name')->get();
        

        $queryExclude = "id not in (select santri_id from view_peserta where semester_id = $semesterActive->id)";
        if (!empty($halaqohId)) {
            /**
             *  Tampilkan nama santri yang belum ada di semester yang aktif pada program yang dipilih.
             *  cth : Abdullah 'Alim - Tahsin 2 , tidak akan bisa di assign lagi ke halaqoh Tahsin 2 lainnya, tapi bisa di assign ke Halaqoh lain seperti Bhs. Arab
             */
            $this->data['selectedHalaqoh'] = $selectedHalaqoh = \App\Model\View\ViewHalaqoh::where('halaqoh_id', $halaqohId)->first();
            $queryExclude = "id not in (select santri_id from view_peserta where semester_id = $semesterActive->id and program_id = $selectedHalaqoh->program_id)";
        }
        $this->data['peserta'] = \App\Model\Santri::whereRaw($queryExclude)->orderBy('name','asc')->get();

        return view('pages.halaqoh.form-tambah-peserta', $this->data);
    }

    function addPesertaPost(Request $request)
    {
        $halaqoh = \App\Model\View\ViewHalaqoh::where('halaqoh_id', $request->halaqoh)->first();
        if (!$halaqoh) {
            return redirect('/halaqoh/peserta/add')->with('alert', ['message'=>"Halaqoh tidak ditemukan", 'type'=>'warning']);
        }

        $santri = \App\Model\Santri::where('id', $request->santri)->first();
        if (!$santri) {
            return redirect('/halaqoh/peserta/add')->with('alert', ['message'=>"Santri tidak ditemukan", 'type'=>'warning']);
        }

        $peserta = new \App\Model\Peserta;
        $peserta->halaqoh_id = $request->halaqoh;
        $peserta->santri_id = $request->santri;

        if ($peserta->save()){

            $peserta->reference = $peserta->id;
            $peserta->save();

            return redirect('/halaqoh/peserta/add')->with('alert', ['message'=>"Santri <b>$santri->name</b> berhasil ditambakan ke halaqoh  :  <b>$halaqoh->pengajar_name ($halaqoh->program_name)</b> ", 'type'=>'success']);
        } else {
            return redirect('/halaqoh/peserta/add')->with('alert', ['message'=>"Menambahkan peserta ke halaqoh gagal dilakukan", 'type'=>'danger']);
        }
    }

    public function manage(Request $request)
    {
        $semesterActive = \App\Model\Semester::getActive();
        $program = \App\Model\Program::select('id','name')->orderBy('sequence','asc')->get();
        $halaqohs = \App\Model\View\ViewHalaqoh::select('program_id', 'pengajar_name', 'day','halaqoh_reference')->where('semester_id', $semesterActive->id)->orderBy('pengajar_name','asc')->get();

        $data = [];
        foreach ($halaqohs as $key => $halaqoh) {
            $data[$halaqoh->day][$halaqoh->program_id][] = (object)['pengajar'=> $halaqoh->pengajar_name, 'reference'=> $halaqoh->halaqoh_reference];
        }

        return view('pages.halaqoh.manage', compact('program', 'data'));
    }
}
