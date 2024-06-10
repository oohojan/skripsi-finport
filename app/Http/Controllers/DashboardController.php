<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pemasok;
use App\Models\Pelanggan;

class DashboardController extends Controller
{
    public function dash_owner()
    {
        $countBarang = Barang::count();
        $countPemasok = Pemasok::count();
        $countPelanggan = Pelanggan::count();
        return view('dashboard_owner', ['count_barang' => $countBarang, 'count_pemasok' => $countPemasok, 'count_pelanggan' => $countPelanggan]);
    }

    public function dash_emp()
    {
        return view('dashboard_emp');
    }
}
