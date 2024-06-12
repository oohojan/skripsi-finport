@extends('layout.mainlayout')

@section('title', 'Dashboard Employee')

@section('content')

    <h1>Welcome to the Apps, {{Auth::user()->Nama}}</h1>

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
                        <div class="card-desc"><a href="add-umkm"style="color: white" >Owner</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

