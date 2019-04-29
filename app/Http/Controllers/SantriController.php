<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
 
class SantriController extends Controller
{
    //di sini isi controller santri
    public function index(){
	    $token = $this->token();
        $listsantri = Curl::to('https://sandbox.fhqannashr.org/santri')
        ->withHeaders( array( 'Content-type: application/json', 'Authorization: Bearer '.$token ))
        ->get();

       $jsonsantri = json_decode($listsantri, true);
       
        return view('santri', $jsonsantri);

	}
}