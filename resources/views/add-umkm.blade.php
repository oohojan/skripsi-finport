@extends('layout.mainlayout')

@section('title', 'Add UMKM')

@section('content')

    <h1>Add UMKM Baru</h1>

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

        <form action="add-umkm" method="post">
            @csrf
            <input type="hidden" name="id_umkm" value="">
            <div>
                <label for="nama_umkm" class="form-label">Name</label>
                <input type="nama_umkm" name="nama_umkm" id="nama_umkm" class="form-control" required>
            </div>
            <div>
                <label for="alamat" class="form-label">Alamat</label>
                <input type="alamat" name="alamat" id="alamat" class="form-control">
            </div>
            <div class="mt-3">
                <button class="btn btn-success" type="submit">Save</button>
            </div>
        </form>
    </div>

@endsection
