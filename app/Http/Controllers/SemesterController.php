<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
 
class SemesterController extends Controller
{
    /**
     * Public container data.
     * Variable ini untuk memudahkan penampungan data.
     * Jadi, cukup 1 variable ini saja yg di pakai, untuk data yg akan di passing ke view.
     * Cukup kirim $this->data, maka semuanya akan terkirim. Jadi insyaalah tidak ada yg kelewat.
     */
    public $data = array();

    //di sini isi controller semester
    public function index()
    {
	    $login = Curl::to(env('API_ENDPOINT').'auth/login')
            ->withHeaders([
                'Content-type: application/x-www-form-urlencoded',
                'Authorization: Bearer'
            ])
            ->withData([ 
                'username' => 'alimm.abdullah@gmail.com', 
                'password' => 'p@ssw0rd', 
                'clientId' => 'fhq-web', 
                'clientSecret' => 'secret' 
            ])
            ->asJson()
            ->post();

        $this->data['semester'] = Curl::to(env('API_ENDPOINT').'semester')
            ->withHeaders([
                'Content-type: application/x-www-form-urlencoded',
                'Authorization: Bearer '.$login->token
            ])
            ->asJson()
            ->get();

        return view('semester', $this->data);

	}
}