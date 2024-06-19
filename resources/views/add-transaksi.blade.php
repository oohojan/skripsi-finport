@extends('layout.mainlayout')

@section('title', 'Add Transaksi')

@section('content')
    <h1>Add Transaksi Baru</h1>

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

        <form action="{{ route('transaksi.store') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi</label>
                <input type="date" class="form-control" id="tanggal_transaksi" name="tanggal_transaksi" required>
            </div>
            <div class="mb-3">
                <label for="jenis_transaksi" class="form-label">Jenis Transaksi</label>
                <select class="form-control" id="jenis_transaksi" name="jenis_transaksi" required>
                    <option value="">Pilih Jenis Transaksi</option>
                    <option value="cash">Cash</option>
                    <option value="debit">Debit</option>
                    <option value="credit">Credit</option>
                    <option value="e-wallet">E-Wallet</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <input type="text" class="form-control" id="keterangan" name="keterangan">
            </div>
            <div class="mb-3">
                <label for="id_pelanggan" class="form-label">Nama Pelanggan</label>
                <select class="form-control" id="id_pelanggan" name="id_pelanggan" required>
                    <option value="">Pilih Pelanggan</option>
                    @foreach ($pelanggan as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Transaksi</button>
        </form>
</div>

@endsection

<script>
    function goBack() {
        window.history.back();
    }
</script>
