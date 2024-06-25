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
            <button onclick="goBack()" class="btn btn-secondary btn-back"><i class="bi bi-arrow-left"></i> Back</button>
            <a href="{{ route('barang.create', $umkm->id) }}" class="btn btn-primary"><i class="bi bi-plus"></i> Add Barang</a>
        </div>

        <form action="{{ route('barang.index', $umkm->id) }}" method="GET" class="mt-3">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search by Nama Barang" value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Search</button>
            </div>
        </form>

        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Harga Jual Barang</th>
                    <th>Harga Beli</th>
                    <th>Jumlah Barang</th>
                    <th>Stok Awal Barang</th>
                    <th>Bulan Input</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barangs as $barang)
                    <tr>
                        <td>{{ $barang->nama_barang }}</td>
                        <td>{{ $barang->harga_barang }}</td>
                        <td>{{ $barang->harga_beli }}</td>
                        <td>{{ $barang->jumlah_barang }}</td>
                        <td>{{ $barang->stok_awal_barang }}</td>
                        <td>{{ $barang->input_bulan}}</td>
                        <td>
                            <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?')"><i class="bi bi-trash3-fill"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $barangs->links('pagination::bootstrap-4') }}
        </div>
    @elseif($action == 'create')
        <h1>Tambah Barang - {{ $umkm->nama_umkm }}</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('barang.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id_umkm" value="{{ $umkm->id }}">
            <div class="mt-3">
                <label for="nama_barang">Nama Barang <span style="color: red;">*</label>
                <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
            </div>
            <div class="mt-3">
                <label for="harga_barang">Harga Jual Barang <span style="color: red;">*</label>
                <input type="text" class="form-control" id="harga_barang" name="harga_barang" required>
            </div>
            <div class="mt-3">
                <label for="harga_beli">Harga Beli <span style="color: red;">*</label>
                <input type="text" class="form-control" id="harga_beli" name="harga_beli" required>
            </div>
            <div class="mt-3">
                <label for="stok_awal_barang">Stok Awal Barang <span style="color: red;">*</label>
                <input type="number" class="form-control" id="stok_awal_barang" name="stok_awal_barang" required>
            </div>
            <div class="mt-3">
                <label for="input_bulan">Input Bulan <span style="color: red;">*</label>
                <select class="form-control" id="input_bulan" name="input_bulan" required>
                    <option value="">Pilih Bulan</option>
                    <option value="January">January</option>
                    <option value="February">February</option>
                    <option value="March">March</option>
                    <option value="April">April</option>
                    <option value="May">May</option>
                    <option value="June">June</option>
                    <option value="July">July</option>
                    <option value="August">August</option>
                    <option value="September">September</option>
                    <option value="October">October</option>
                    <option value="November">November</option>
                    <option value="December">December</option>
                </select>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i> Submit</button>
                <a href="{{ route('barang.index', $umkm->id) }}" class="btn btn-secondary"><i class="bi bi-x"></i> Cancel</a>
            </div>

        </form>
    @elseif($action == 'edit')
        <h1>Edit Barang</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('barang.update') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $barang->id }}">
            <div class="mt-3">
                <label for="nama_barang">Nama Barang</label>
                <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="{{ $barang->nama_barang }}" required>
            </div>
            <div class="mt-3">
                <label for="harga_barang">Harga Jual Barang</label>
                <input type="text" class="form-control" id="harga_barang" name="harga_barang" value="{{ $barang->harga_barang }}" required>
            </div>
            <div class="mt-3">
                <label for="harga_beli">Harga Beli</label>
                <input type="text" class="form-control" id="harga_beli" name="harga_beli" value="{{ $barang->harga_beli }}" required>
            </div>
            <div class="mt-3">
                <label for="stok_awal_barang">Stok Awal Barang</label>
                <input type="number" class="form-control" id="stok_awal_barang" name="stok_awal_barang" value="{{ $barang->stok_awal_barang }}" required>
            </div>
            <div class="mt-3">
                <label for="jumlah_barang">Sisa Barang</label>
                <input type="number" class="form-control" id="jumlah_barang" name="jumlah_barang" value="{{ $barang->jumlah_barang }}" required>
            </div>
            <div class="mt-3">
                <label for="input_bulan">Input Bulan</label>
                <select class="form-control" id="input_bulan" name="input_bulan" required>
                    <option value="">Pilih Bulan</option>
                    <option value="January" {{ $barang->input_bulan == 'January' ? 'selected' : '' }}>January</option>
                    <option value="February" {{ $barang->input_bulan == 'February' ? 'selected' : '' }}>February</option>
                    <option value="March" {{ $barang->input_bulan == 'March' ? 'selected' : '' }}>March</option>
                    <option value="April" {{ $barang->input_bulan == 'April' ? 'selected' : '' }}>April</option>
                    <option value="May" {{ $barang->input_bulan == 'May' ? 'selected' : '' }}>May</option>
                    <option value="June" {{ $barang->input_bulan == 'June' ? 'selected' : '' }}>June</option>
                    <option value="July" {{ $barang->input_bulan == 'July' ? 'selected' : '' }}>July</option>
                    <option value="August" {{ $barang->input_bulan == 'August' ? 'selected' : '' }}>August</option>
                    <option value="September" {{ $barang->input_bulan == 'September' ? 'selected' : '' }}>September</option>
                    <option value="October" {{ $barang->input_bulan == 'October' ? 'selected' : '' }}>October</option>
                    <option value="November" {{ $barang->input_bulan == 'November' ? 'selected' : '' }}>November</option>
                    <option value="December" {{ $barang->input_bulan == 'December' ? 'selected' : '' }}>December</option>
                </select>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i> Submit</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary"><i class="bi bi-x"></i> Cancel</a>
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
