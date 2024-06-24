<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Pelanggan;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelangganController extends Controller
{
    public function pelanggan(Request $request)
    {
        $user = Auth::user();

        // Cek peran pengguna
        if ($user->id_role == 1) {
            // Jika pengguna adalah owner
            $umkm = Umkm::where('id_user', $user->id)->first();

            if ($umkm) {
                $query = Pelanggan::where('id_umkm', $umkm->id);
            } else {
                $query = Pelanggan::where('id_umkm', null); // Atau bisa diganti dengan collect() jika tidak ingin menampilkan data jika UMKM tidak ditemukan
            }
        } elseif ($user->id_role == 2) {
            // Jika pengguna adalah employee
            $employee = Employee::where('id_user', $user->id)->first();

            if ($employee) {
                $query = Pelanggan::where('id_umkm', $employee->id_umkm);
            } else {
                $query = Pelanggan::where('id_umkm', null); // Atau bisa diganti dengan collect() jika tidak ingin menampilkan data jika UMKM tidak ditemukan
            }
        } else {
            // Peran tidak valid
            abort(403, 'Unauthorized action.');
        }

        // Filter berdasarkan pencarian
        $search = $request->input('search');
        if ($search) {
            $pelanggan = $query->where('nama', 'LIKE', '%' . $search . '%')->get();
        } else {
            $pelanggan = $query->get();
        }

        return view('pelanggan', ['pelanggan' => $pelanggan]);
    }

    public function add(){
        $user = Auth::user();
        if ($user->id_role == 1) {
            // If the user is an owner, get the UMKM ID from the user's UMKM relationship
            if (!$user->umkm) {
                return redirect()->route('pelanggan')->with('error', 'UMKM tidak ditemukan.');
            }
            $umkmId = $user->umkm->id;
        } elseif ($user->id_role == 2) {
            // If the user is an employee, get the UMKM ID from the first UMKM they are associated with
            $umkm = Umkm::whereHas('employees', function ($query) use ($user) {
                $query->where('id_user', $user->id);
            })->first();

            if (!$umkm) {
                return redirect()->route('pelanggan')->with('error', 'UMKM tidak ditemukan.');
            }

            $umkmId = $umkm->id;
        } else {
            // If the user does not have a valid role, redirect back with an error
            return redirect()->route('pelanggan')->with('error', 'Role user tidak valid.');
        }
        return view('add-pelanggan', ['umkmId' => $umkmId]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|max:100',
            'no_telepon' => 'max:100',
            'alamat' => 'max:255',
        ]);

        $user = Auth::user();

        // Determine the UMKM ID based on the user's role
        if ($user->id_role == 1) {
            // If the user is an owner
            $umkm = Umkm::where('id_user', $user->id)->first();
            if (!$umkm) {
                return redirect()->route('pelanggan')->with('error', 'UMKM tidak ditemukan.');
            }
            $umkmId = $umkm->id;
        } elseif ($user->id_role == 2) {
            // If the user is an employee
            $employee = Employee::where('id_user', $user->id)->first();
            if (!$employee) {
                return redirect()->route('pelanggan')->with('error', 'UMKM tidak ditemukan.');
            }
            $umkmId = $employee->id_umkm;
        } else {
            // Invalid role
            return redirect()->route('pelanggan')->with('error', 'Role user tidak valid.');
        }

        $pelanggan = new Pelanggan();
        $pelanggan->fill($request->all());
        $pelanggan->id_umkm = $umkmId;
        $pelanggan->save();

        return redirect()->route('pelanggan')->with('status', 'Pelanggan berhasil didaftarkan!');
    }

    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('edit-pelanggan', ['pelanggan' => $pelanggan]);
    }

    public function update(Request $request, $id)
    {
        $validated =$request->validate([
            'nama' => 'required|max:100',
            'no_telepon' => 'max:100',
            'alamat' => 'max:255',
        ]);

        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update($request->all());
        return redirect('pelanggan')->with('status', 'Pemasok Berhasil Di Edit!');
    }

    public function destroy($id)
    {
        Pelanggan::findOrFail($id)->delete();
        return redirect('pelanggan');
    }
}
