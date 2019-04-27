<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
 
class SantriController extends Controller
{
    //di sini isi controller santri
    public function index(){
	    $login = Curl::to('https://sandbox.fhqannashr.org/auth/login')
        ->withHeaders( array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer' ) )
        ->withData( array( 'username' => 'alimm.abdullah@gmail.com', 'password' => 'p@ssw0rd', 'clientId' => 'fhq-web', 'clientSecret' => 'secret' ))
        ->post();
        $json = json_decode($login, true);
        $token = $json['token'];

        $listsantri = Curl::to('https://sandbox.fhqannashr.org/santri')
        ->withHeaders( array( 'Content-type: application/json', 'Authorization: Bearer '.$token ))
        ->get();

       $jsonsantri = json_decode($listsantri, true);
       
        return view('santri', $jsonsantri);

	}
}