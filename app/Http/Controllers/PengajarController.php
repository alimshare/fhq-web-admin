<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
 
class PengajarController extends Controller
{
    //di sini isi controller santri
    public function getAll(){
        $token = $this->token();
        $listpengajar = Curl::to('https://sandbox.fhqannashr.org/pengajar')
        ->withHeaders( array( 'Content-type: application/json', 'Authorization: Bearer '.$token ))
        ->get();

       $jsonpengajar = json_decode($listpengajar, true);
       
        return view('pengajar', $jsonpengajar);

	}
}