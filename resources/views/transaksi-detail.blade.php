@extends('layout.mainlayout')

@section('title', 'Detail Transaksi')

@section('content')

<h1>Detail Transaksi</h1>

<div class="mt-3">
    <button onclick="goBack()" class="btn btn-secondary">Back</button>
</div>

<div class="mt-5 d-flex justify-content-end">
    <a href="{{ route('transaksi.addDetail', ['id' => $transaksi->id]) }}" class="btn btn-primary">Add Detail</a>
</div>

<!-- Formulir Pencarian -->
<form action="{{ route('transaksi-detail', ['id' => $transaksi->id]) }}" method="GET" class="mt-3">
    <div class="input-group mb-3">
        <input type="text" class="form-control" name="search" placeholder="Search by Nama Barang" value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>

<div class="my-5">
    <table class="table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detailTransaksi as $index => $detail)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $detail->barang->nama_barang }}</td>
                <td>{{ $detail->jumlah }}</td>
                <td>{{ $detail->harga }}</td>
                <td>{{ $detail->jumlah * $detail->harga }}.00</td>
                <td>
                    <a href="{{ route('transaksi.editDetail', ['id' => $detail->id]) }}" class="btn btn-primary">Edit</a>
                    <form id="delete-form-{{ $detail->id }}" action="{{ route('transaksi.destroyDetail', ['id' => $detail->id]) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ $detail->id }}')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

<script>
    function confirmDelete(detailId) {
        if (confirm('Apakah Anda yakin ingin menghapus detail transaksi ini?')) {
            document.getElementById('delete-form-' + detailId).submit();
        }
    }

    function goBack() {
        window.history.back();
    }
</script>
