<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
 
class SantriController extends Controller
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

    //di sini isi controller santri
    public function index(){
	    // $token = $this->token();
     //    $this->data['santri'] = Curl::to(env('API_ENDPOINT').'santri')
     //    ->withHeaders(['Content-type: application/json', 'Authorization: Bearer '.$token])
     //    ->asJson()
     //    ->get();
     //    dd($this->data);
     

    	$this->data['list'] = \App\Model\Santri::all();
        return view('pages.santri.list', $this->data);


	}
}