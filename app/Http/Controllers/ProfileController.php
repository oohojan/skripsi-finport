<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile(Request $request)
    {
        $user = Auth()->user();

        return view('profile', compact('user'));
    }

    public function editProfile(Request $request)
    {
        $user = Auth::user();
        return view('edit-profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_telepon' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'password' => 'nullable|string|max:30',
        ]);

        $user = Auth::user();
        $user->Nama = $request->nama;
        $user->email = $request->email;
        $user->No_Telepon = $request->no_telepon;
        $user->address = $request->address;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($user->save()) {
            return redirect()->route('profile')->with('success', 'Profile updated successfully.');
        } else {
            return redirect()->route('profile.edit')->with('error', 'Failed to update profile.');
        }
    }

}
