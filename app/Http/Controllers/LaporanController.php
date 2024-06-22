<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function laporan()
    {
        // Mendapatkan data laporan keuangan per bulan
        $laporan = $this->getLaporanKeuanganPerBulan();

        return view('lap_keuangan', compact('laporan'));
    }

    public function detailLaporan($bulan)
    {
        // Konversi nama bulan ke format angka (1 - 12)
        $bulanNum = Carbon::parse($bulan)->month;
        $data = $this->hitungLaporanKeuangan($bulanNum);

        return view('detail_lap_keuangan', compact('bulan', 'data'));
    }

    private function getLaporanKeuanganPerBulan()
    {
        $laporan = [];
        for ($i = 1; $i <= 12; $i++) {
            $bulan = Carbon::create()->month($i)->format('F');
            $laporan[$bulan] = $this->hitungLaporanKeuangan($i);
        }
        return $laporan;
    }

    private function hitungLaporanKeuangan($bulan)
    {
        // Mengonversi bulan ke nama bulan dalam format teks
        $namaBulan = Carbon::create()->month($bulan)->format('F');

        // Mengambil barang yang diinput pada bulan tertentu
        $barangInputBulanan = Barang::where('input_bulan', $namaBulan)->get();
        $detailBarang = [];

        // Inisialisasi detailBarang dengan barang-barang yang diinput pada bulan tertentu
        foreach ($barangInputBulanan as $barang) {
            $detailBarang[$barang->id] = [
                'nama_barang' => $barang->nama_barang,
                'harga_beli' => $barang->harga_beli,
                'harga_jual' => $barang->harga_barang,
                'jumlah_terjual' => 0,
                'stok_awal_barang' => $barang->stok_awal_barang,
            ];
        }

        // Mengambil transaksi berdasarkan bulan
        $transaksi = Transaksi::whereMonth('tanggal_transaksi', $bulan)->get();

        $totalPendapatanKotor = 0;
        $totalModal = 0;

        foreach ($transaksi as $trans) {
            $detailTransaksi = DetailTransaksi::where('id_transaksi', $trans->id)->get();

            foreach ($detailTransaksi as $detail) {
                if (isset($detail->id_barang) && isset($detailBarang[$detail->id_barang])) {
                    $barang = Barang::find($detail->id_barang);

                    // Menghitung pendapatan kotor
                    $hargaJual = $barang->harga_barang; // Menggunakan harga_barang
                    $pendapatanKotor = $hargaJual * $detail->jumlah;
                    $totalPendapatanKotor += $pendapatanKotor;

                    // Menambahkan jumlah terjual ke detailBarang
                    $detailBarang[$detail->id_barang]['jumlah_terjual'] += $detail->jumlah;

                    // Reset variabel barang untuk menghindari masalah referensi
                    $barang = null;
                }
            }
        }

        // Menghitung total modal berdasarkan stok awal barang yang diinput pada bulan tertentu
        foreach ($detailBarang as $barang) {
            $totalModal += $barang['harga_beli'] * $barang['stok_awal_barang'];
        }

        // Menghitung pendapatan bersih dan rugi
        $pendapatanBersih = $totalPendapatanKotor - $totalModal;
        $rugi = $pendapatanBersih < 0 ? abs($pendapatanBersih) : 0;

        return [
            'total_pendapatan_kotor' => $totalPendapatanKotor,
            'total_pendapatan_bersih' => $pendapatanBersih,
            'total_modal' => $totalModal,
            'rugi' => $rugi,
            'detail_barang' => $detailBarang,
            'ada_transaksi' => $transaksi->count() > 0,
        ];
    }
}
