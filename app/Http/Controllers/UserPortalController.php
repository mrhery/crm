<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use Hash;

class UserPortalController extends Controller
{
    use AuthenticatesUsers;

    // protected $redirectTo = '/staff/dashboard';

    public function __construct() {
        // $this->middleware('guest')->except('logout');
    }

    public function checkRole() {
        if(Session::get('role_id') != 'ROD005') {
            // return view('staff.login');
            return redirect()->route('staff.login');
        }
    }

    public function login(Request $request) {
        $input = $request->all();
        
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        $user_details = User::where('email', $request->email)->first();
        
        if(Hash::check($request->password, $user_details->password) && $user_details->role_id == 'ROD005') {
            Session::put('user_id', $user_details->user_id);
            Session::put('role_id', $user_details->role_id);
            Session::put('isLogin', 1);

            return redirect()->route('staff.dashboard');
        }else {
            return redirect()->route('staff.login')->with('error','Email-Address And Password Are Wrong.');
        }

        // if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password']))){
        //     return redirect()->route('staff.dashboard');
        // }else{
        //     return redirect()->route('staff.login')->with('error','Email-Address And Password Are Wrong.');
        // }
    }

    public function showLoginForm() {
        if(Session::get('isLogin')) {
            return redirect()->route('staff.dashboard');
        }
        return view('staff.login');
    }

    public function index() {
        $this->checkRole();
        
        return view('staff.dashboard');
    }

    public function logout() {
        Session::flush();

        return redirect("staff/login");
    }
}
