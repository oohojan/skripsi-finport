<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pemasok;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dash_owner()
    {
        $umkmId = Auth::user()->umkm->id;

        $countBarang = Barang::where('id_umkm', $umkmId)->count();
        $countPemasok = Pemasok::where('id_umkm', $umkmId)->count();
        $countPelanggan = Pelanggan::where('id_umkm', $umkmId)->count();

        $transaksi = Transaksi::todayTransactions($umkmId)->get();

        return view('dashboard_owner', [
            'count_barang' => $countBarang,
            'count_pemasok' => $countPemasok,
            'count_pelanggan' => $countPelanggan,
            'transaksi' => $transaksi
        ]);
    }

    public function dash_emp()
    {
        $transaksi = Transaksi::todayTransactions()->get();

        return view('dashboard_emp', [
            'transaksi' => $transaksi
        ]);
    }
}
