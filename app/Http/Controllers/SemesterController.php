<?php

namespace App\Http\Controllers;

use App\Model\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public $data = array();

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->data['list'] = Semester::orderBy('name','desc')->get();
        return view('pages.semester.list', $this->data);
    }

    public function add()
    {
        $this->data['semesters'] = Semester::orderBy('name','desc')->get();
        return view('pages.semester.form', $this->data);
    }

    public function edit($id)
    {
        $this->data['semester'] = Semester::find($id);
        if (is_null($this->data['semester'])) {
            return redirect('semester');
        }
        $this->data['semesters'] = Semester::where('id', '!=', $id)->orderBy('name','desc')->get();
        return view('pages.semester.form', $this->data);
    }

    public function save(Request $request)
    {
        $id = $request->input('id');

        $message = "";
        $messageType = "success";

        if (!$id) {
            $semester = new Semester;
        } else {
            $semester = Semester::find($id);
            if (is_null($semester)) {
                return redirect('semester');
            }
        }

        $semester->name         = $request->input('name');
        $semester->description  = $request->input('description');
        $semester->start_period = $request->input('start_period');
        $semester->end_period   = $request->input('end_period');
        $semester->active           = $request->input('active') ? 1 : 0;
        $semester->next_semester_id = $request->input('next_semester_id') ?: null;

        if ($semester->active) {
            Semester::where('id', '!=', $semester->id)->where('active', 1)->update(['active' => 0]);
        }

        if ($semester->save()) {
            $message = $id ? "Ubah data semester berhasil" : "Simpan data semester berhasil";
        } else {
            $message = $id ? "Ubah data semester gagal" : "Simpan data semester gagal";
            $messageType = "danger";
        }

        return redirect('semester')->with('alert', ['message' => $message, 'type' => $messageType]);
    }
}
