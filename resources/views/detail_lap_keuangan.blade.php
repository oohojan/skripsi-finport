@extends('layout.mainlayout')

@section('title', 'Detail Laporan Keuangan')

@section('content')
    <div style="margin: 20px;">
        <h1 style="margin-bottom: 20px;">Detail Laporan Keuangan - {{ $bulan }}</h1>

        @if ($data['ada_transaksi'])
            <div style="margin-bottom: 20px;">
                <h2>Ringkasan</h2>
                <p>Total Pendapatan Kotor: <strong>Rp {{ number_format($data['total_pendapatan_kotor'], 0, ',', '.') }}</strong></p>
                <p>Total Modal: <strong>Rp {{ number_format($data['total_modal'], 0, ',', '.') }}</strong></p>
                <p>Total Pendapatan Bersih: <strong>Rp {{ number_format($data['total_pendapatan_bersih'], 0, ',', '.') }}</strong></p>
                <p>Rugi: <strong>Rp {{ number_format($data['rugi'], 0, ',', '.') }}</strong></p>
            </div>

            <div style="margin-bottom: 20px;">
                <h2>Detail Barang Terjual</h2>
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #f2f2f2;">
                            <th style="padding: 10px; text-align: left;">Nama Barang</th>
                            <th style="padding: 10px; text-align: left;">Harga Beli (per barang)</th>
                            <th style="padding: 10px; text-align: left;">Harga Jual (per barang)</th>
                            <th style="padding: 10px; text-align: left;">Jumlah Terjual</th>
                            <th style="padding: 10px; text-align: left;">Stok Awal Barang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['detail_barang'] as $barang)
                            <tr style="border-bottom: 1px solid #ddd;">
                                <td style="padding: 10px;">{{ $barang['nama_barang'] }}</td>
                                <td style="padding: 10px;">Rp {{ number_format($barang['harga_beli'], 0, ',', '.') }}</td>
                                <td style="padding: 10px;">Rp {{ number_format($barang['harga_jual'], 0, ',', '.') }}</td>
                                <td style="padding: 10px;">{{ $barang['jumlah_terjual'] }}</td>
                                <td style="padding: 10px;">{{ $barang['stok_awal_barang'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p style="margin-bottom: 20px;">Tidak terdapat transaksi di bulan ini.</p>
        @endif
    </div>
@endsection
