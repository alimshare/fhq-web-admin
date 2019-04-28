<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
 
class PengajarController extends Controller
{
    //di sini isi controller santri
    public function getAll(){
	    $login = Curl::to('https://sandbox.fhqannashr.org/auth/login')
        ->withHeaders( array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer' ) )
        ->withData( array( 'username' => 'alimm.abdullah@gmail.com', 'password' => 'p@ssw0rd', 'clientId' => 'fhq-web', 'clientSecret' => 'secret' ))
        ->post();
        $json = json_decode($login, true);
        $token = $json['token'];

        $listpengajar = Curl::to('https://sandbox.fhqannashr.org/pengajar')
        ->withHeaders( array( 'Content-type: application/json', 'Authorization: Bearer '.$token ))
        ->get();

       $jsonpengajar = json_decode($listpengajar, true);
       
        return view('pengajar', $jsonpengajar);

	}
}