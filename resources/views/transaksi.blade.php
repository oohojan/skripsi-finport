@extends('layout.mainlayout')

@section('title', 'Transaksi')

<style>
    .not-joined-business {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 60vh;
        text-align: center;
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
    }

    .message-container {
        padding: 20px;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .message-container h1 {
        font-size: 24px;
        font-weight: bold;
        color: #343a40;
    }

    .message-container p {
        font-size: 18px;
        color: #6c757d;
    }
</style>

@section('content')
    @if (Auth::user()->have_business == 0)
    <div class="not-joined-business">
        <div class="message-container">
            <h1>Silahkan join UMKM di halaman dashboard</h1>
        </div>
    </div>
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

    <form action="{{ route('transaksi') }}" method="GET" class="mt-3">
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="search" placeholder="Search by Keterangan or Nama Pelanggan" value="{{ request('search') }}">
            <input type="date" class="form-control" name="date" placeholder="Search by Tanggal Transaksi" value="{{ request('date') }}">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

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
        <div class="d-flex justify-content-center">
            {{ $transaksi->links('pagination::bootstrap-4') }}
        </div>
    </div>
    @endif
@endsection
