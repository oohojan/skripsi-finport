<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailTransaksi;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function transaksi()
    {
        // Ambil ID user yang sedang login
        $userId = Auth::user()->id;

        // Cek apakah user merupakan owner atau employee
        if (Auth::user()->id_role == 1) {
            $user = Auth::user();
            $umkmId = $user->umkm->id;
            // Jika owner, ambil transaksi berdasarkan umkm yang dimilikinya
            $transaksi = Transaksi::where('id_umkm', $umkmId)->get();
        } elseif (Auth::user()->id_role == 2) {
            // Jika employee, ambil transaksi berdasarkan umkm tempat dia bekerja
            $transaksi = Transaksi::whereHas('umkm', function ($query) use ($userId) {
                $query->whereHas('employees', function ($query) use ($userId) {
                    $query->where('id_user', $userId);
                });
            })->get();
        }

        return view('transaksi', compact('transaksi'));
    }

    public function detail($id)
    {
        $transaksi = Transaksi::with(['pelanggan', 'detailTransaksi.barang'])->find($id);
        return view('transaksi-detail', compact('transaksi'));
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return redirect()->route('transaksi')->with('error', 'Transaksi tidak ditemukan.');
        }

        // Hapus detail transaksi yang terkait
        $transaksi->detailTransaksi()->delete();

        // Hapus transaksi
        $transaksi->delete();

        return redirect()->route('transaksi')->with('success', 'Transaksi berhasil dihapus.');
    }

    public function addTransaksi()
    {
        $user = Auth::user();
        if ($user->id_role == 1) {
            // If the user is an owner, get the UMKM ID from the user's UMKM relationship
            if (!$user->umkm) {
                return redirect()->route('transaksi')->with('error', 'UMKM tidak ditemukan.');
            }
            $umkmId = $user->umkm->id;
        } elseif ($user->id_role == 2) {
            // If the user is an employee, get the UMKM ID from the first UMKM they are associated with
            $umkm = Umkm::whereHas('employees', function ($query) use ($user) {
                $query->where('id_user', $user->id);
            })->first();

            if (!$umkm) {
                return redirect()->route('transaksi')->with('error', 'UMKM tidak ditemukan.');
            }

            $umkmId = $umkm->id;
        } else {
            // If the user does not have a valid role, redirect back with an error
            return redirect()->route('transaksi')->with('error', 'Role user tidak valid.');
        }

        // Ambil pelanggan yang terkait dengan UMKM
        $pelanggan = Pelanggan::where('id_umkm', $umkmId)->get();

        return view('add-transaksi', compact('pelanggan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'jenis_transaksi' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'id_pelanggan' => 'required|exists:pelanggan,id'
        ]);

        $user = Auth::user();
        $umkmId = $user->umkm->id;

        Transaksi::create([
            'id_umkm' => $umkmId,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'jenis_transaksi' => $request->jenis_transaksi,
            'keterangan' => $request->keterangan,
            'id_pelanggan' => $request->id_pelanggan
        ]);

        return redirect()->route('transaksi')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function addDetail($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $barang = Barang::where('id_umkm', $transaksi->id_umkm)->get();

        return view('add-detail', compact('transaksi', 'barang'));
    }

    public function storeDetail(Request $request, $id)
    {
        $request->validate([
            'id_barang' => 'required|exists:barang,id',
            'jumlah' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0'
        ]);

        $transaksi = Transaksi::findOrFail($id);

        $detailTransaksi = new DetailTransaksi();
        $detailTransaksi->id_transaksi = $transaksi->id;
        $detailTransaksi->id_barang = $request->id_barang;
        $detailTransaksi->jumlah = $request->jumlah;
        $detailTransaksi->harga = $request->harga;
        $detailTransaksi->save();

        // Kurangi jumlah_barang di tabel barang
        $barang = Barang::findOrFail($request->id_barang);
        $barang->jumlah_barang -= $request->jumlah;
        $barang->save();

        return redirect()->route('transaksi-detail', ['id' => $transaksi->id])->with('success', 'Detail transaksi berhasil ditambahkan.');
    }

    public function destroyDetail($id)
    {
        $detailTransaksi = DetailTransaksi::findOrFail($id);

        // Kembalikan jumlah barang ke tabel barang
        $barang = Barang::findOrFail($detailTransaksi->id_barang);
        $barang->jumlah_barang += $detailTransaksi->jumlah;
        $barang->save();

        // Hapus detail transaksi
        $detailTransaksi->delete();

        return redirect()->back()->with('success', 'Detail transaksi berhasil dihapus.');
    }

    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $user = Auth::user();
        if ($user->id_role == 1) {
            // If the user is an owner, get the UMKM ID from the user's UMKM relationship
            $umkmId = $user->umkm->id;
        } elseif ($user->id_role == 2) {
            // If the user is an employee, get the UMKM ID from the transaction's UMKM relationship
            $umkmId = $transaksi->id_umkm;
        } else {
            // If the user does not have a valid role, redirect back with an error
            return redirect()->route('transaksi')->with('error', 'Role user tidak valid.');
        }
        $pelanggan = Pelanggan::where('id_umkm', $umkmId)->get();

        return view('edit-transaksi', compact('transaksi', 'pelanggan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'jenis_transaksi' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'id_pelanggan' => 'required|exists:pelanggan,id'
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->tanggal_transaksi = $request->tanggal_transaksi;
        $transaksi->jenis_transaksi = $request->jenis_transaksi;
        $transaksi->keterangan = $request->keterangan;
        $transaksi->id_pelanggan = $request->id_pelanggan;
        $transaksi->save();

        return redirect()->route('transaksi')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function editDetail($id)
    {
        $detailTransaksi = DetailTransaksi::findOrFail($id);
        $barang = Barang::where('id_umkm', $detailTransaksi->transaksi->id_umkm)->get();

        return view('edit-detail', compact('detailTransaksi', 'barang'));
    }

    public function updateDetail(Request $request, $id)
    {
        $request->validate([
            'id_barang' => 'required|exists:barang,id',
            'jumlah' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0'
        ]);

        $detailTransaksi = DetailTransaksi::findOrFail($id);
        $transaksi = $detailTransaksi->transaksi;

        // Check if the barang is different
        if ($detailTransaksi->id_barang != $request->id_barang) {
            // Restore previous quantity to barang lama
            $barangLama = Barang::findOrFail($detailTransaksi->id_barang);
            $barangLama->jumlah_barang += $detailTransaksi->jumlah;
            $barangLama->save();

            // Deduct new quantity from barang baru
            $barangBaru = Barang::findOrFail($request->id_barang);
            $barangBaru->jumlah_barang -= $request->jumlah;
            $barangBaru->save();
        } else {
            // If barang is the same, calculate the difference in quantity
            $difference = $request->jumlah - $detailTransaksi->jumlah;

            // Adjust barang quantity accordingly
            $barang = Barang::findOrFail($request->id_barang);
            $barang->jumlah_barang -= $difference;
            $barang->save();
        }

        // Update detail transaksi
        $detailTransaksi->id_barang = $request->id_barang;
        $detailTransaksi->jumlah = $request->jumlah;
        $detailTransaksi->harga = $request->harga;
        $detailTransaksi->save();

        return redirect()->route('transaksi-detail', ['id' => $transaksi->id])->with('success', 'Detail transaksi berhasil diupdate.');
    }
}
