<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Pelanggan;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelangganController extends Controller
{
    public function pelanggan()
    {
        $user = Auth::user();

        // Cek peran pengguna
        if ($user->id_role == 1) {
            // Jika pengguna adalah owner
            $umkm = Umkm::where('id_user', $user->id)->first();

            if ($umkm) {
                $pelanggan = Pelanggan::where('id_umkm', $umkm->id)->get();
            } else {
                $pelanggan = collect();
            }
        } elseif ($user->id_role == 2) {
            // Jika pengguna adalah employee
            $employee = Employee::where('id_user', $user->id)->first();

            if ($employee) {
                $pelanggan = Pelanggan::where('id_umkm', $employee->id_umkm)->get();
            } else {
                $pelanggan = collect();
            }
        } else {
            // Peran tidak valid
            abort(403, 'Unauthorized action.');
        }

        return view('pelanggan', ['pelanggan' => $pelanggan]);
    }

    public function add(){
        $user = Auth::user();
        $umkm = Umkm::where('id_user', $user->id)->first();
        return view('add-pelanggan', ['umkm' => $umkm]);
    }

    public function store(Request $request){

        $validated =$request->validate([
            'nama' => 'required|max:100',
            'no_telepon' => 'max:100',
            'alamat' => 'max:255',
        ]);

        $user = Auth::user();
        $umkm = Umkm::where('id_user', $user->id)->first();
        $pelanggan = new Pelanggan();
        $pelanggan->fill($request->all());
        $pelanggan->id_umkm = $umkm->id;
        $pelanggan->save();
        return redirect ('pelanggan')->with('status', 'Pemasok Berhasil Didaftarkan!');
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
