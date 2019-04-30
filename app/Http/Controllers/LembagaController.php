<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
 
class LembagaController extends Controller
{
    //di sini isi controller lembaga
    public function index(){
        $token = $this->token();
        $this->data['lembaga'] = Curl::to(env('API_ENDPOINT').'lembaga')
        ->withHeaders(['Content-type: application/json', 'Authorization: Bearer '.$token ])
        ->asJson()
        ->get();

        return view('lembaga', $this->data);
	}
}