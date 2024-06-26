<?php

namespace App\Http\Controllers;

use App\Models\Pemasok;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemasokController extends Controller
{
    public function pemasok(Request $request)
    {
        $user = Auth::user();
        $umkm = Umkm::where('id_user', $user->id)->first();
        $search = $request->input('search');

        if ($umkm) {
            $query = Pemasok::where('id_umkm', $umkm->id);

            if ($search) {
                $query->where('name', 'LIKE', "%{$search}%");
            }

            $pemasok = $query->get();
        } else {
            $pemasok = collect();
        }

        $pemasok = $query->paginate(10);

        return view('pemasok', ['pemasok' => $pemasok]);
    }

    public function add(){
        $user = Auth::user();
        $umkm = Umkm::where('id_user', $user->id)->first();
        return view('add-pemasok', ['umkm' => $umkm]);
    }

    public function store(Request $request){
        $validated =$request->validate([
            'name' => 'required|max:100',
            'no_telepon' => 'max:100',
            'alamat' => 'max:255',
            'keterangan' => 'max:255',
        ]);

        $user = Auth::user();
        $umkm = Umkm::where('id_user', $user->id)->first();
        $pemasok = new Pemasok();
        $pemasok->fill($request->all());
        $pemasok->id_umkm = $umkm->id;
        $pemasok->save();
        return redirect ('pemasok')->with('status', 'Pemasok Berhasil Didaftarkan!');
    }

    public function edit($id)
    {
        $pemasok = Pemasok::findOrFail($id);
        return view('edit-pemasok', ['pemasok' => $pemasok]);
    }

    public function update(Request $request, $id)
    {
        $validated =$request->validate([
            'name' => 'required|max:100',
            'no_telepon' => 'max:100',
            'alamat' => 'max:255',
            'keterangan' => 'max:255',
        ]);

        $pemasok = Pemasok::findOrFail($id);
        $pemasok->update($request->all());
        return redirect('pemasok')->with('status', 'Pemasok Berhasil Di Edit!');
    }

    public function destroy($id)
    {
        Pemasok::findOrFail($id)->delete();
        return redirect('pemasok');
    }
}
