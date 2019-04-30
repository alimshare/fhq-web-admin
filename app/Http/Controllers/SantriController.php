<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
 
class SantriController extends Controller
{
    //di sini isi controller santri
    public function index(){
	    $token = $this->token();
        $this->data['santri'] = Curl::to(env('API_ENDPOINT').'santri')
        ->withHeaders(['Content-type: application/json', 'Authorization: Bearer '.$token])
        ->asJson()
        ->get();
       
        return view('santri', $this->data);

	}
}