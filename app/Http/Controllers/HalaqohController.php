<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    	// $this->data['halaqoh'] = $this->hit_api("semester/{$reference}/halaqoh", "get");
    	// $this->data['semester_reference'] = $reference;
        
        $this->data['list'] = \App\Model\View\ViewHalaqoh::all();
        return view('pages.halaqoh.list', $this->data);
    }

    /**
     * Add halaqoh, show a new form
     */
    public function add(Request $request)
    {
    	$this->data['program'] = $this->hit_api("program", "get");
    	$this->data['pengajar'] = $this->hit_api("pengajar", "get");

    	// dd($this->data);
    	return view('halaqoh-form', $this->data);
    }

    /**
     * Save/update halaqoh
     */
    public function save(Request $request, $reference=null)
    {
    	$with_data = [
    		'program' => $request->input('program'),
    		'nip' => $request->input('nip'),
    		'day' => $request->input('day'),
    		'start_hour' => $request->input('start_hour'),
    		'semester' => $request->input('semester')
    	];

    	if ($reference) 
    	{
	    	$halaqoh = $this->hit_api("halaqoh/edit/{$reference}", "put", $with_data);
	    	return redirect("halaqoh/{$reference}");
    	}
    	else
    	{
	    	$halaqoh = $this->hit_api("halaqoh/add", "post", $with_data);
	    	return redirect("semester/{$request->input('semester')}/halaqoh");
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
            $peserta = \App\Model\PendidikanSantri::find($pesertaId);
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
}
