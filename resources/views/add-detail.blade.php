@extends('layout.mainlayout')

@section('title', 'Add Detail Transaksi')

@section('content')
<h1>Add Detail</h1>

<div class="mt-5 d-flex justify-content-end">
    <a href="{{ route('transaksi-detail', ['id' => $transaksi->id]) }}" class="btn btn-secondary">Back</a>
</div>

<div class="mt-5 w-75">
    <form action="{{ route('transaksi.storeDetail', ['id' => $transaksi->id]) }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="id_barang" class="form-label">Barang</label>
            <select class="form-control" id="id_barang" name="id_barang" required>
                <option value="">Pilih Barang</option>
                @foreach ($barang as $item)
                    <option value="{{ $item->id }}">{{ $item->nama_barang }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" required>
        </div>
        <div class="mb-3">
            <label for="harga" class="form-label">Harga Satuan</label>
            <input type="number" step="0.01" class="form-control" id="harga" name="harga" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Detail</button>
    </form>
</div>

@endsection
