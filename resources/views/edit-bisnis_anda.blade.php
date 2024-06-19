@extends('layout.mainlayout')

@section('title', 'Bisnis Anda')

@section('content')
    <h1>Bisnis Anda</h1>

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

    <form action="{{ route('bisnis.update', $umkm->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mt-5">
            <div class="mt-3">
                <label for="nama_umkm">Nama Bisnis:</label>
                <input type="text" name="nama_umkm" class="form-control" id="nama_umkm" value="{{ $umkm->nama_umkm }}">
            </div>

            <div class="mt-3">
                <label for="alamat_umkm">Alamat Bisnis:</label>
                <input type="text" name="alamat_umkm" class="form-control" id="alamat_umkm" value="{{ $umkm->alamat_umkm }}">
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('bisnis_anda') }}" class="btn btn-secondary">Cancel</a>
            </div>

        </div>
    </form>

@endsection
