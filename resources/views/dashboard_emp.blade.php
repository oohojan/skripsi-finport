@extends('layout.mainlayout')

@section('title', 'Dashboard Employee')

@section('content')

    <h1>Welcome to the Apps, {{ Auth::user()->Nama }}</h1>

    @if (Auth::user()->have_business == 0)
        @if ($statusPending)
            <div class="alert alert-warning mt-5">
                Akun Anda belum disetujui, silahkan hubungi owner.
            </div>
        @else
            <div class="mt-5">
                <h4>Apakah kamu ingin menjadi Employee atau menjadi Owner?, silahkan pilih!</h4>
            </div>

            <div class="row mt-3">
                <div class="col-lg-6">
                    <div class="card-data barang">
                        <div class="row">
                            <div class="col-6">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div class="col-6 d-flex flex-column justify-content-center align-items-end">
                                <div class="card-desc"><a href="umkm-list" style="color: white">Employee</a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card-data pemasok">
                        <div class="row">
                            <div class="col-6">
                                <i class="bi bi-person-standing"></i>
                            </div>
                            <div class="col-6 d-flex flex-column justify-content-center align-items-end">
                                <div class="card-desc"><a href="add-umkm" style="color: white">Owner</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @elseif (Auth::user()->have_business == 1)
        <div class="mt-5">
            <h3>Daftar Transaksi Hari ini</h3>
            @include('partials.transaksi', ['transaksi' => $transaksi])
        </div>
    @endif

@endsection
