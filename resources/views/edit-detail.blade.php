@extends('layout.mainlayout')

@section('title', 'Edit Detail Transaksi')

@section('content')
<h1>Edit Detail</h1>

<div class="mt-5 d-flex justify-content-end">
    <a href="{{ route('transaksi-detail', ['id' => $detailTransaksi->transaksi->id]) }}" class="btn btn-secondary">Back</a>
</div>

<div class="mt-5 w-75">
    <form action="{{ route('transaksi.updateDetail', ['id' => $detailTransaksi->id]) }}" method="post">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="id_barang" class="form-label">Barang</label>
            <select class="form-control" id="id_barang" name="id_barang" required>
                <option value="">Pilih Barang</option>
                @foreach ($barang as $item)
                    <option value="{{ $item->id }}" {{ $item->id === $detailTransaksi->id_barang ? 'selected' : '' }}>{{ $item->nama_barang }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ $detailTransaksi->jumlah }}" required>
        </div>
        <div class="mb-3">
            <label for="harga" class="form-label">Harga Satuan</label>
            <input type="number" step="0.01" class="form-control" id="harga" name="harga" value="{{ $detailTransaksi->harga }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Detail</button>
    </form>
</div>

@endsection
