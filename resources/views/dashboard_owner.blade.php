@extends('layout.mainlayout')

@section('title', 'Dashboard Owner')

@section('content')

    <h1>Welcome to the Apps, {{Auth::user()->Nama}}</h1>

    <div class="row mt-5">
        <div class="col-lg-4">
            <div class="card-data barang">
                <div class="row">
                    <div class="col-6">
                        <i class="bi bi-bag-plus"></i>
                    </div>
                    <div class="col-6 d-flex flex-column justify-content-center align-items-end">
                        <div class="card-desc">Barang</div>
                        <div class="card-count">{{$count_barang}}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card-data pemasok">
                <div class="row">
                    <div class="col-6">
                        <i class="bi bi-truck"></i>
                    </div>
                    <div class="col-6 d-flex flex-column justify-content-center align-items-end">
                        <div class="card-desc">Pemasok</div>
                        <div class="card-count">{{$count_pemasok}}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card-data transaksi">
                <div class="row">
                    <div class="col-6">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="col-6 d-flex flex-column justify-content-center align-items-end">
                        <div class="card-desc">Pelanggan</div>
                        <div class="card-count">{{$count_pelanggan}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <h3>Daftar Transaksi Hari ini</h3>
        @if ($transaksi->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal Transaksi</th>
                    <th>Jenis Transaksi</th>
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
                    <td>{{ $item->pelanggan->nama }}</td>
                    <td>
                        <a href="{{ route('transaksi-detail', ['id' => $item->id]) }}" class="btn btn-primary">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal Transaksi</th>
                        <th>Jenis Transaksi</th>
                        <th>Nama Pelanggan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4" style="text-align: center">Tidak ada data transaksi hari ini.</td>
                    </tr>
                </tbody>
            </table>
        @endif


    </div>
@endsection
