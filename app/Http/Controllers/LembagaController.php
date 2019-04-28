<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
 
class LembagaController extends Controller
{
    //di sini isi controller lembaga
    public function index(){
        $token = $this->token();
        $listlembaga = Curl::to('https://sandbox.fhqannashr.org/lembaga')
        ->withHeaders( array( 'Content-type: application/json', 'Authorization: Bearer '.$token ))
        ->get();

        $jsonlembaga = json_decode($listlembaga, true);

        return view('lembaga', $jsonlembaga);
	}
}