<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Umkm;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index($id)
    {
        $umkm = Umkm::find($id);
        $barangs = Barang::where('id_umkm', $id)->get();
        return view('barang', ['action' => 'index', 'umkm' => $umkm, 'barangs' => $barangs]);
    }

    public function create($id)
    {
        $umkm = UMKM::find($id);
        return view('barang', ['action' => 'create', 'umkm' => $umkm]);
    }

    public function store(Request $request)
    {
        $barang = new Barang;
        $barang->id_umkm = $request->id_umkm;
        $barang->nama_barang = $request->nama_barang;
        $barang->harga_barang = $request->harga_barang;
        $barang->jumlah_barang = $request->jumlah_barang;
        $barang->save();

        return redirect()->route('barang.index', $request->id_umkm)->with('success', 'Barang added successfully');
    }

    public function edit($id)
    {
        $barang = Barang::find($id);
        return view('barang', ['action' => 'edit', 'barang' => $barang]);
    }

    public function update(Request $request)
    {
        $barang = Barang::find($request->id);
        $barang->nama_barang = $request->nama_barang;
        $barang->harga_barang = $request->harga_barang;
        $barang->jumlah_barang = $request->jumlah_barang;
        $barang->save();

        return redirect()->route('barang.index', $barang->id_umkm)->with('success', 'Barang updated successfully');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->back()->with('success', 'Barang deleted successfully');
    }
}
