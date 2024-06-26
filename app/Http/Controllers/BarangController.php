<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class BarangController extends Controller
{
    public function index(Request $request, $id)
    {
        $umkm = Umkm::findOrFail($id);
        $search = $request->input('search');

        if ($search) {
            $barangs = Barang::where('id_umkm', $id)
                ->where('nama_barang', 'LIKE', "%{$search}%")
                ->get();
        } else {
            $barangs = Barang::where('id_umkm', $id)->get();
        }

        // Pagination
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($barangs);
        $currentPageItems = $itemCollection->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginatedItems = new LengthAwarePaginator($currentPageItems, count($itemCollection), $perPage);
        $paginatedItems->setPath($request->url());

        return view('barang', ['action' => 'index', 'umkm' => $umkm, 'barangs' => $paginatedItems]);
    }

    public function create($id)
    {
        $umkm = Umkm::find($id);
        return view('barang', ['action' => 'create', 'umkm' => $umkm]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'harga_barang' => 'required|numeric|min:0',
            'harga_beli' => 'required|numeric|min:0',
            'stok_awal_barang' => 'required|integer|min:0',
            'input_bulan' => 'required|string|max:255'
        ]);

        $barang = new Barang;
        $barang->id_umkm = $request->id_umkm;
        $barang->nama_barang = $request->nama_barang;
        $barang->harga_barang = $request->harga_barang;
        $barang->harga_beli = $request->harga_beli;
        $barang->stok_awal_barang = $request->stok_awal_barang;
        $barang->jumlah_barang = $request->stok_awal_barang;
        $barang->input_bulan = $request->input_bulan;
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
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'harga_barang' => 'required|numeric|min:0',
            'harga_beli' => 'required|numeric|min:0',
            'stok_awal_barang' => 'required|integer|min:0',
            'jumlah_barang' => 'required|integer|min:0',
            'input_bulan' => 'required|string|max:255'
        ]);

        $barang = Barang::findOrFail($request->id);
        $barang->nama_barang = $request->nama_barang;
        $barang->harga_barang = $request->harga_barang;
        $barang->harga_beli = $request->harga_beli;
        $barang->stok_awal_barang = $request->stok_awal_barang;
        $barang->jumlah_barang = $request->jumlah_barang;
        $barang->input_bulan = $request->input_bulan;
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
