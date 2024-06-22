@extends('layout.mainlayout')

@section('title', 'Detail Laporan Keuangan')

@section('content')
    <h1>Detail Laporan Keuangan - {{ $bulan }}</h1>

    @if ($data['ada_transaksi'])
        <h2>Ringkasan</h2>
        <p>Total Pendapatan Kotor: Rp {{ number_format($data['total_pendapatan_kotor'], 0, ',', '.') }}</p>
        <p>Total Modal: Rp {{ number_format($data['total_modal'], 0, ',', '.') }}</p>
        <p>Total Pendapatan Bersih: Rp {{ number_format($data['total_pendapatan_bersih'], 0, ',', '.') }}</p>
        <p>Rugi: Rp {{ number_format($data['rugi'], 0, ',', '.') }}</p>

        <h2>Detail Barang Terjual</h2>
        <table>
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Harga Beli (per barang)</th>
                    <th>Harga Jual (per barang)</th>
                    <th>Jumlah Terjual</th>
                    <th>Stok Awal Barang</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['detail_barang'] as $barang)
                    <tr>
                        <td>{{ $barang['nama_barang'] }}</td>
                        <td>Rp {{ number_format($barang['harga_beli'], 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($barang['harga_jual'], 0, ',', '.') }}</td>
                        <td>{{ $barang['jumlah_terjual'] }}</td>
                        <td>{{ $barang['stok_awal_barang'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Tidak terdapat transaksi di bulan ini.</p>
    @endif
@endsection
