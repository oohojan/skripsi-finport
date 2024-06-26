<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerification;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            // If the email does not exist
            return redirect('login')->withErrors(['email' => 'Email tidak terdaftar di sistem.']);
        }

        if ($user && !$user->hasVerifiedEmail()) {
            // If the email is not verified
            return redirect('login')->withErrors(['email' => 'Your email address is not verified.']);
        }

        if ($user && !Hash::check($credentials['password'], $user->password)) {
            // If the password does not match
            return redirect('login')->withErrors(['password' => 'Password tidak sesuai.']);
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->id_role == 1) {
                return redirect('dashboard_owner');
            }
            if ($user->id_role == 2) {
                return redirect('dashboard_emp');
            }
        }

        Session::flash('status', 'gagal');
        Session::flash('message', 'Gagal Login');
        return redirect('login');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }

    public function registerUser(Request $request)
    {
        $validate = $request->validate([
            'Nama' => 'required|max:255',
            'email' => 'required|unique:users|max:255|regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/',
            'password' => 'required|max:255|min:8',
            'No_Telepon' => 'nullable|max:255|min:12',
            'address' => 'nullable|max:255',
        ]);

        $user = User::create([
            'Nama' => $request->Nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'No_Telepon' => $request->No_Telepon,
            'address' => $request->address,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect('/email/verify');
    }

}
