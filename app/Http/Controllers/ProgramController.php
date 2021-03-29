<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\{DB, Cache};
 
class ProgramController extends Controller
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
     * Public container data.
     * Variable ini untuk memudahkan penampungan data.
     * Jadi, cukup 1 variable ini saja yg di pakai, untuk data yg akan di passing ke view.
     * Cukup kirim $this->data, maka semuanya akan terkirim. Jadi insyaalah tidak ada yg kelewat.
     */

    public $data = array();

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

        $colorList = array('#F7464A', '#46BFBD', '#FDB45C', '#0097a7', '#d84315', '#6d4c41','#283593', '#c2185b', '#00695c', '#9e9d24', '#01579b','#6a1b9a' ,'#ec407a', '#ea80fc', '#b0bed6', '#f5b3f3', '#ff8269');
        for ($i=0; $i < count($program); $i++) { 
            $colorIndex = array_rand($colorList, 1);
            $program[$i]->color = $colorList[$colorIndex];
            unset($colorList[$colorIndex]);
        }

        $this->data['list'] = (Object) $program;

        return view('pages.program.list', $this->data);
    }
}