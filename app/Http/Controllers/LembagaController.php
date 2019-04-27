<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
 
class LembagaController extends Controller
{
    //di sini isi controller lembaga
    public function index(){
	    $login = Curl::to('https://sandbox.fhqannashr.org/auth/login')
        ->withHeaders( array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer' ) )
        ->withData( array( 'username' => 'alimm.abdullah@gmail.com', 'password' => 'p@ssw0rd', 'clientId' => 'fhq-web', 'clientSecret' => 'secret' ))
        ->post();
        $jsonlogin = json_decode($login, true);
       //foreach ($json as $p) {
		//echo $p->token;
	//	}
        $token = $jsonlogin['token'];
        $listlembaga = Curl::to('https://sandbox.fhqannashr.org/lembaga')
        ->withHeaders( array( 'Content-type: application/json', 'Authorization: Bearer '.$token ))
        ->get();

        $jsonlembaga = json_decode($listlembaga, true);

        return view('lembaga', $jsonlembaga);
	}
}