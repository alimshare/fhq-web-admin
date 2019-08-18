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
    	$this->data['program'] = $this->hit_api("program", "get");
    	$this->data['pengajar'] = $this->hit_api("pengajar", "get");
    	$this->data['halaqoh'] = $this->hit_api("halaqoh/{$reference}", "get");
    	$this->data['reference'] = $reference;

    	// dd($this->data);
    	return view('halaqoh-form', $this->data);
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
