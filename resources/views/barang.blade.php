@extends('layout.mainlayout')

@section('title', 'Barang')

@section('content')

<style>
    .btn-back {
        margin-right: 10px;
    }
</style>

<div class="container">
    @if($action == 'index')
        <h1>Stok Barang - {{ $umkm->nama_umkm }}</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="mt-5 d-flex justify-content-end">
            <button onclick="goBack()" class="btn btn-secondary btn-back">Back</button>
            <a href="{{ route('barang.create', $umkm->id) }}" class="btn btn-primary">Add Barang</a>
        </div>

        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Harga Barang</th>
                    <th>Jumlah Barang</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barangs as $barang)
                    <tr>
                        <td>{{ $barang->nama_barang }}</td>
                        <td>{{ $barang->harga_barang }}</td>
                        <td>{{ $barang->jumlah_barang }}</td>
                        <td>
                            <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @elseif($action == 'create')
        <h1>Tambah Barang - {{ $umkm->nama_umkm }}</h1>

        <form action="{{ route('barang.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id_umkm" value="{{ $umkm->id }}">
            <div class="mt-3">
                <label for="nama_barang">Nama Barang</label>
                <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
            </div>
            <div class="mt-3">
                <label for="harga_barang">Harga Barang</label>
                <input type="text" class="form-control" id="harga_barang" name="harga_barang" required>
            </div>
            <div class="mt-3">
                <label for="jumlah_barang">Jumlah Barang</label>
                <input type="number" class="form-control" id="jumlah_barang" name="jumlah_barang" required>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('barang.index', $umkm->id) }}" class="btn btn-secondary">Cancel</a>
            </div>

        </form>
    @elseif($action == 'edit')
        <h1>Edit Barang</h1>

        <form action="{{ route('barang.update') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $barang->id }}">
            <div class="mt-3">
                <label for="nama_barang">Nama Barang</label>
                <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="{{ $barang->nama_barang }}" required>
            </div>
            <div class="mt-3">
                <label for="harga_barang">Harga Barang</label>
                <input type="text" class="form-control" id="harga_barang" name="harga_barang" value="{{ $barang->harga_barang }}" required>
            </div>
            <div class="mt-3">
                <label for="jumlah_barang">Jumlah Barang</label>
                <input type="number" class="form-control" id="jumlah_barang" name="jumlah_barang" value="{{ $barang->jumlah_barang }}" required>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
            </div>

        </form>
    @endif
</div>
@endsection

<script>
    function goBack() {
        window.history.back();
    }
</script>
