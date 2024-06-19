@extends('layout.mainlayout')

@section('title', 'Transaksi')

@section('content')
    @if (Auth::user()->have_business == 0)
    <h1>Kamu belum bergabung ke sebuah UMKM</h1>
    @elseif (Auth::user()->have_business == 1)
    <h1>List Transaksi</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="mt-5 d-flex justify-content-end">
        <a href="{{ route('transaksi.addTransaksi') }}" class="btn btn-primary">Add</a>
    </div>

    <div class="my-5">
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal Transaksi</th>
                    <th>Jenis Transaksi</th>
                    <th>Keterangan</th>
                    <th>Nama Pelanggan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksi as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->tanggal_transaksi }}</td>
                    <td>{{ $item->jenis_transaksi }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td>{{ $item->pelanggan->nama }}</td>
                    <td>
                        <a href="{{ route('transaksi.edit', ['id' => $item->id]) }}" class="btn btn-info">Edit</a>
                        <a href="{{ route('transaksi-detail', ['id' => $item->id]) }}" class="btn btn-primary">Detail</a>
                        <form action="{{ route('transaksi.destroy', ['id' => $item->id]) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
@endsection
