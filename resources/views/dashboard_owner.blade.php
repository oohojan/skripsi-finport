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
        @include('partials.transaksi', ['transaksi' => $transaksi])
    </div>


    </div>
@endsection
