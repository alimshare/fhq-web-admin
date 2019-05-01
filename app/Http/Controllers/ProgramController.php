<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
 
class ProgramController extends Controller
{
    /**
     * Public container data.
     * Variable ini untuk memudahkan penampungan data.
     * Jadi, cukup 1 variable ini saja yg di pakai, untuk data yg akan di passing ke view.
     * Cukup kirim $this->data, maka semuanya akan terkirim. Jadi insyaalah tidak ada yg kelewat.
     */

    public $data = array();

    public function index(){
        $token = $this->token();

        $this->data['program'] = Curl::to(env('API_ENDPOINT').'program')
            ->withHeaders([
                'Content-type: application/x-www-form-urlencoded',
                'Authorization: Bearer '.$token
            ])
            ->asJson()
            ->get();

        return view('program', $this->data);
    }
}