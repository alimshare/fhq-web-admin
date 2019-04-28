<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;

class JwtLoginController extends Controller
{

	public function showLoginForm(Request $req)
	{
		return view('login');
	}

    public function login(Request $req)
    {

        $email      = $req->input('email');
        $password   = $req->input('password');

    	$login = Curl::to(env('API_ENDPOINT').'auth/login')
            ->withHeaders([
                'Content-type: application/x-www-form-urlencoded',
                'Authorization: Bearer'
            ])
            ->withData([ 
                'username' => $email, 
                'password' => $password, 
                'clientId' => 'fhq-web', 
                'clientSecret' => 'secret' 
            ])
            ->asJson()
            ->post();

        if ($login->code != 'SUCCESS') {
            return redirect('/show')->with('message', $login->message);
        }

        $token = $login->token;
        setcookie("token", $token, time()+3600); // token will be expired after 1 hour

        if (isset($_COOKIE['token'])) {
            return redirect('/lembaga');
        } else {
            return redirect('/show')->with('message', 'Please contact Administrator to solve the problem.');;
        }
    }

}
