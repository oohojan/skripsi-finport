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
    public function transaksi(Request $request)
    {
        $userId = Auth::user()->id;
        $search = $request->input('search');
        $date = $request->input('date');

        if (Auth::user()->id_role == 1) {
            $user = Auth::user();
            $umkmId = $user->umkm->id;
            $query = Transaksi::where('id_umkm', $umkmId);
        } elseif (Auth::user()->id_role == 2) {
            $query = Transaksi::whereHas('umkm', function ($query) use ($userId) {
                $query->whereHas('employees', function ($query) use ($userId) {
                    $query->where('id_user', $userId);
                });
            });
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('keterangan', 'LIKE', "%{$search}%")
                    ->orWhereHas('pelanggan', function ($q) use ($search) {
                        $q->where('nama', 'LIKE', "%{$search}%");
                    });
            });
        }

        if ($date) {
            $query->whereDate('tanggal_transaksi', $date);
        }

        $transaksi = $query->get();

        return view('transaksi', compact('transaksi'));
    }

    public function detail(Request $request, $id)
    {
        $search = $request->input('search');

        // Ambil transaksi beserta detail dan relasi barang
        $transaksi = Transaksi::with(['pelanggan', 'detailTransaksi.barang'])->find($id);

        if ($search) {
            // Filter detail transaksi berdasarkan nama barang
            $detailTransaksi = $transaksi->detailTransaksi->filter(function ($detail) use ($search) {
                return stripos($detail->barang->nama_barang, $search) !== false;
            });
        } else {
            $detailTransaksi = $transaksi->detailTransaksi;
        }

        return view('transaksi-detail', compact('transaksi', 'detailTransaksi'));
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

        // Mendapatkan bulan transaksi
        $bulanTransaksi = date('F', strtotime($transaksi->tanggal_transaksi));  // 'F' menghasilkan nama bulan penuh (misalnya, "June")

        // Mendapatkan barang berdasarkan id_umkm dan bulan input
        $barang = Barang::where('id_umkm', $transaksi->id_umkm)
                        ->where('input_bulan', $bulanTransaksi)
                        ->get();

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

        // Mendapatkan barang untuk memastikan harga benar
        $barang = Barang::findOrFail($request->id_barang);
        if ($request->harga != $barang->harga_barang) {
            return redirect()->back()->withErrors(['harga' => 'Harga satuan harus sesuai dengan harga barang.']);
        }

        $detailTransaksi = new DetailTransaksi();
        $detailTransaksi->id_transaksi = $transaksi->id;
        $detailTransaksi->id_barang = $request->id_barang;
        $detailTransaksi->jumlah = $request->jumlah;
        $detailTransaksi->harga = $request->harga;
        $detailTransaksi->save();

        // Kurangi jumlah_barang di tabel barang
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
        $transaksi = $detailTransaksi->transaksi;

        // Mendapatkan bulan transaksi
        $bulanTransaksi = date('F', strtotime($transaksi->tanggal_transaksi)); // 'F' menghasilkan nama bulan penuh (misalnya, "June")

        // Mendapatkan barang berdasarkan id_umkm dan bulan input
        $barang = Barang::where('id_umkm', $transaksi->id_umkm)
                        ->where('input_bulan', $bulanTransaksi)
                        ->get();

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
        $barang = Barang::findOrFail($request->id_barang);

        // Pastikan harga sesuai dengan harga barang
        if ($request->harga != $barang->harga_barang) {
            return redirect()->back()->withErrors(['harga' => 'Harga satuan harus sesuai dengan harga barang.']);
        }

        // Update detail transaksi
        $detailTransaksi->id_barang = $request->id_barang;
        $detailTransaksi->jumlah = $request->jumlah;
        $detailTransaksi->harga = $request->harga;
        $detailTransaksi->save();

        // Kurangi jumlah barang jika berubah
        $barangAsal = Barang::findOrFail($detailTransaksi->id_barang);
        if ($barangAsal->id != $barang->id) {
            $barangAsal->jumlah_barang += $detailTransaksi->jumlah; // Tambah kembali jumlah pada barang asal
            $barang->jumlah_barang -= $request->jumlah; // Kurangi jumlah pada barang baru
            $barangAsal->save();
        } else {
            $barangAsal->jumlah_barang += ($detailTransaksi->jumlah - $request->jumlah);
        }

        $barang->save();

        return redirect()->route('transaksi-detail', ['id' => $detailTransaksi->id_transaksi])->with('success', 'Detail transaksi berhasil diperbarui.');
    }
}
