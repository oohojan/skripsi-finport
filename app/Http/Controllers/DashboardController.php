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
        $id_umkm = Auth::user()->id;

        $countBarang = Barang::where('id_umkm', $id_umkm)->count();

        $countPemasok = Pemasok::where('id_umkm', $id_umkm)->count();

        $countPelanggan = Pelanggan::where('id_umkm', $id_umkm)->count();

        $user = Auth::user();
        $umkmId = $user->umkm->id;

        $transaksi = Transaksi::where('id_umkm', $umkmId)
                    ->whereDate('tanggal_transaksi', today()->addDays(1))
                    ->get();

        return view('dashboard_owner', ['count_barang' => $countBarang, 'count_pemasok' => $countPemasok, 'count_pelanggan' => $countPelanggan, 'transaksi' => $transaksi]);
    }

    public function dash_emp()
    {
        return view('dashboard_emp');
    }
}
