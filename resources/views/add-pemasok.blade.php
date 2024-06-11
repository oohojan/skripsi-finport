@extends('layout.mainlayout')

@section('title', 'Add Pemasok')

@section('content')

    <h1>Add Pemasok Baru</h1>

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

        <form action="add-pemasok" method="post">
            @csrf
            <input type="hidden" name="id_umkm" value="{{ $umkm->id }}">
            <div>
                <label for="name" class="form-label">Name</label>
                <input type="name" name="name" id="name" class="form-control" required>
            </div>
            <div>
                <label for="no_telepon" class="form-label">No.Telepon</label>
                <input type="no_telepon" name="no_telepon" id="no_telepon" class="form-control">
            </div>
            <div>
                <label for="alamat" class="form-label">Alamat</label>
                <input type="alamat" name="alamat" id="alamat" class="form-control">
            </div>
            <div>
                <label for="keterangan" class="form-label">Keterangan</label>
                <input type="keterangan" name="keterangan" id="keterangan" class="form-control">
            </div>
            <div class="mt-3">
                <button class="btn btn-success" type="submit">Save</button>
            </div>
        </form>
    </div>

@endsection

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
