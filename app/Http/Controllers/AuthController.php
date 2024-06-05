<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login ()
    {
        return view('login');
    }

    public function register ()
    {
        return view('register');
    }

    public function authenticating(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ]);

        if(Auth::attempt($credentials)){
            //dd(Auth::user());
            //$request->session()->regenerate();
            if(Auth::user()->id_role == 1){
                return redirect('dashboard_owner');
            }
            if(Auth::user()->id_role == 2){
                return redirect('dashboard_emp');
            }
        }

        Session::flash('status','gagal');
        Session::flash('message', 'Gagal Login');
        return redirect('login');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}
