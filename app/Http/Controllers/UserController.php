<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // $this->data['list'] = User::select('id','username')->with('profile')->orderBy('username','asc')->get();
        $this->data['list'] = User::orderBy('username','asc')->with(['profile'])->get();
        return view('pages.user.list', $this->data);
    }

    public function resetPassword(Request $req, $userId)
    {
        $user = User::find($userId);
        if (!$user) {
            return redirect('users');
        }

        $defaultPassword = env('DEFAULT_RESET_PASSWORD','password');
        $user->password = Hash::make($defaultPassword);
        if ($user->save()) {
            return redirect('/users')->with('alert', ['message'=>"Reset password for <b>$user->username</b> is success :  <em>$defaultPassword</em> ", 'type'=>'success']);
        } else {
            return redirect('/users')->with('alert', ['message'=>"Reset password is fail", 'type'=>'danger']);
        }

        return redirect()->back();
    }
}
