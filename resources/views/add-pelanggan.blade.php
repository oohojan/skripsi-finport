@extends('layout.mainlayout')

@section('title', 'Add Pelanggan')

@section('content')

    <h1>Add Pelanggan</h1>

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

        <form action="add-pelanggan" method="post">
            @csrf
            <input type="hidden" name="id_umkm" value="{{ $umkmId }}">
            <div>
                <label for="nama" class="form-label">Name</label>
                <input type="nama" name="nama" id="nama" class="form-control" required>
            </div>
            <div>
                <label for="no_telepon" class="form-label">No.Telepon</label>
                <input type="no_telepon" name="no_telepon" id="no_telepon" class="form-control">
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

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
