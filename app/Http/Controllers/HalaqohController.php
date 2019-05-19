<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HalaqohController extends Controller
{
    /**
     * Global variable
     */
    public $data = array();

    /**
     * Get all lists reference by semester
     */
    public function lists(Request $request, $reference=null)
    {
    	$this->data['halaqoh'] = $this->hit_api("semester/{$reference}/halaqoh", "get");
    	dd($this->data);
    	return view("halaqoh", $this->data);
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
    	// dd($request->all());

    	$with_data = [
    		'program' => $request->input('program'),
    		'nip' => $request->input('nip'),
    		'day' => $request->input('day'),
    		'start_hour' => $request->input('start_hour'),
    		'semester' => $request->input('semester')
    	];

    	$halaqoh = $this->hit_api("halaqoh/add", "post", $with_data);
    	return redirect("semester/{$request->input('semester')}/halaqoh");
    }
}
