@extends('layout.mainlayout')

@section('title', 'Bisnis Anda')

@section('content')
    <h1>UMKM Anda</h1>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="mt-5">
        <div class="mt-3">
            <label for="nama_umkm">Nama UMKM:</label>
            <input type="text" class="form-control" id="nama_umkm" value="{{ $umkm->nama_umkm }}" readonly>
        </div>

        <div class="mt-3">
            <label for="alamat_umkm">Alamat UMKM:</label>
            <input type="text" class="form-control" id="alamat_umkm" value="{{ $umkm->alamat_umkm }}" readonly>
        </div>

        <div class="mt-3">
            <a href="{{ route('bisnis.edit', $umkm->id) }}" class="btn btn-primary">Update UMKM</a>
            <a href="{{ route('barang.index', $umkm->id) }}" class="btn btn-secondary">Stock Barang</a>
        </div>

    </div>

@endsection
