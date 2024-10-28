<?php

namespace App\Http\Controllers;

use App\Model\Pengajar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserController extends Controller
{
    private $data = [];

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

    function add() {
        $this->data['profiles'] = $profiles = Pengajar::select('pengajar.id','pengajar.name')
            ->leftJoin('users', 'users.profile_id', 'pengajar.id')
            ->whereNull('users.id')->get();
        
        return view('pages.user.add', $this->data);
    }

    function create(Request $request) {
        
        $validatedData = $request->validate([
            'username'      => 'required|unique:users,username',
            'password'      => 'required|min:6|same:confirm_password',
            'profile_id'    => 'required|unique:users,profile_id'
        ]);

        $profile = Pengajar::find($request->profile_id);
        if (!$profile) {
            return redirect()->route('users')->with('alert', ['message'=>'Profile Pengajar tidak ditemukan !', 'type'=>'danger']);
        }
        
        $user = new User;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->name = $profile->name;
        $user->email = '';
        $user->profile_type = 'App\Model\Pengajar';
        $user->profile_id = $request->profile_id;

        if ($user->save()){
            return redirect()->route('users')->with('alert', ['message'=>'Create new user success !', 'type'=>'success']);    
        } else {
            return redirect()->route('users')->with('alert', ['message'=>'Failed to create new user. please contact administrator !', 'type'=>'danger']);
        }
    }

    /**
     * Show the change password form
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function changePassword()
    {
        return view('pages.change-password');
    }

    public function changePasswordProcess(Request $req)
    { 
        
        $validatedData = $req->validate([
            'old_password'  => 'required',
            'new_password'  => 'required|min:6|same:confirm_password'
        ]);

        if (Hash::check($req->input('old_password'), auth()->user()->password)) {
            $currentUser = \App\User::find(auth()->user()->id);
            $currentUser->password = Hash::make($req->input('new_password'));
            if ($currentUser->save()){
                return redirect('/change-password')->with('alert', ['message'=>'Change password success, please re-login to application using your new password !', 'type'=>'success']);    
            } else {
                return redirect('/change-password')->with('alert', ['message'=>'Change password fail', 'type'=>'danger']);
            }

        } else {            
            return redirect('/change-password')->with('alert', ['message'=>'Your current password invalid !', 'type'=>'danger']);
        }
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
