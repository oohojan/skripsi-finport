@extends('layout.mainlayout')

@section('title', 'Transaksi')

@section('content')
    @if (Auth::user()->have_business == 0)
        <h1>Kamu belum bergabung ke sebuah UMKM</h1>
    @elseif (Auth::user()->have_business == 1)
        <h1>Ini halaman transaksi</h1>
    @endif
@endsection
