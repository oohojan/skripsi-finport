@extends('layout.mainlayout')

@section('title', 'Edit Transaksi')

@section('content')
<h1>Edit Transaksi</h1>

<div class="mt-5 d-flex justify-content-end">
    <button onclick="goBack()" class="btn btn-secondary">Back</button>
</div>

<div class="mt-5 w-75">
    @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    <form action="{{ route('transaksi.update', ['id' => $transaksi->id]) }}" method="post">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi</label>
            <input type="date" class="form-control" id="tanggal_transaksi" name="tanggal_transaksi" value="{{ $transaksi->tanggal_transaksi }}" required>
        </div>
        <div class="mb-3">
            <label for="jenis_transaksi" class="form-label">Jenis Transaksi</label>
            <select class="form-control" id="jenis_transaksi" name="jenis_transaksi" required>
                <option value="cash" {{ $transaksi->jenis_transaksi == 'cash' ? 'selected' : '' }}>Cash</option>
                <option value="debit" {{ $transaksi->jenis_transaksi == 'debit' ? 'selected' : '' }}>Debit</option>
                <option value="credit" {{ $transaksi->jenis_transaksi == 'credit' ? 'selected' : '' }}>Credit</option>
                <option value="e-wallet" {{ $transaksi->jenis_transaksi == 'e-wallet' ? 'selected' : '' }}>E-Wallet</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <input type="text" class="form-control" id="keterangan" name="keterangan" value="{{ $transaksi->keterangan }}">
        </div>
        <div class="mb-3">
            <label for="id_pelanggan" class="form-label">Nama Pelanggan</label>
            <select class="form-control" id="id_pelanggan" name="id_pelanggan" required>
                @foreach ($pelanggan as $item)
                <option value="{{ $item->id }}" {{ $transaksi->id_pelanggan == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Transaksi</button>
    </form>
</div>

<script>
    function goBack() {
        window.history.back();
    }
</script>
@endsection
