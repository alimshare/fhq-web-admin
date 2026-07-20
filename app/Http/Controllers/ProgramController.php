<?php

namespace App\Http\Controllers;

use App\Model\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Cache};

class ProgramController extends Controller
{
    public $data = array();

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        $program = Cache::remember('program.all', 60*60*24, function(){
            $semesterActive = \App\Model\Semester::getActive();
            $SQL = "SELECT program_name, halaqoh, ( SELECT COUNT(1) AS peserta FROM view_peserta WHERE program_id = T1.program_id AND semester_id = '".$semesterActive->id."') AS peserta
                    FROM (
                        SELECT program_id, program_name, SUM(1) AS halaqoh FROM `view_halaqoh`
                        WHERE semester_id = '". $semesterActive->id ."'
                        GROUP BY program_id, program_name
                    ) T1";
            return DB::select($SQL); // sementara pake native query
        });

        $countProgram = count($program);
        for ($i=0; $i < $countProgram; $i++) {
            $program[$i]->color = $this->getRandomColor();
        }

        $this->data['list'] = (Object) $program;
        $this->data['programs'] = Program::orderBy('sequence')->get();

        return view('pages.program.list', $this->data);
    }

    public function add()
    {
        $this->data['programs'] = Program::orderBy('sequence')->get();
        return view('pages.program.add', $this->data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:60',
            'sequence' => 'nullable|integer',
            'description' => 'nullable|string|max:150',
            'infaq' => 'nullable|numeric|min:0',
        ]);

        $program = new Program();
        $program->name = $request->input('name');
        $program->sequence = $request->input('sequence');
        $program->description = $request->input('description');
        $program->infaq = $request->input('infaq', 0);
        $program->next_program_id = $request->input('next_program_id');

        if ($program->next_program_id) {
            $nextProgram = Program::find($program->next_program_id);
            if ($nextProgram) {
                $program->next_program = $nextProgram->name;
            }
        }

        if ($program->save()) {
            Cache::forget('program.all');
            $message = "Tambah program berhasil";
            $messageType = "success";
        } else {
            $message = "Tambah program gagal";
            $messageType = "danger";
        }

        return redirect('program')->with('alert', ['message' => $message, 'type' => $messageType]);
    }

    public function edit($id)
    {
        $this->data['program'] = Program::find($id);
        if (is_null($this->data['program'])) {
            return redirect('program');
        }
        $this->data['programs'] = Program::where('id', '!=', $id)->orderBy('sequence')->get();
        return view('pages.program.form', $this->data);
    }

    public function save(Request $request)
    {
        $id = $request->input('id');

        $program = Program::find($id);
        if (is_null($program)) {
            return redirect('program');
        }

        $program->next_program_id = $request->input('next_program_id');
        $program->next_program    = null;

        if ($program->next_program_id) {
            $nextProgram = Program::find($program->next_program_id);
            if ($nextProgram) {
                $program->next_program = $nextProgram->name;
            }
        }

        if ($program->save()) {
            Cache::forget('program.all');
            $message = "Ubah data program berhasil";
            $messageType = "success";
        } else {
            $message = "Ubah data program gagal";
            $messageType = "danger";
        }

        return redirect('program')->with('alert', ['message' => $message, 'type' => $messageType]);
    }

    public function getRandomColor()
    {
        $colorList = array(
            '#F7464A', '#46BFBD', '#FDB45C', '#0097a7', '#d84315',
            '#6d4c41', '#283593', '#c2185b', '#00695c', '#9e9d24',
            '#01579b', '#6a1b9a', '#ec407a', '#ea80fc', '#b0bed6',
            '#f5b3f3', '#ff8269', '#2cdada', '#9a0b0b', '#1a73e8',
            '#10294a', '#188038', '#bac', '#5ecc59', '#72777c'
        );

        $randomIndex = array_rand($colorList, 1);
        return $colorList[$randomIndex];
    }
}
