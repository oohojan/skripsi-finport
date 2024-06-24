@extends('layout.mainlayout')

@section('title', 'Pelanggan')

@section('content')
    @if (Auth::user()->have_business == 0)
        <h1>Kamu belum bergabung ke sebuah UMKM</h1>
    @elseif (Auth::user()->have_business == 1)
    <h1>
        List Pelanggan
    </h1>

    <div class="mt-5 d-flex justify-content-end">
        <a href="add-pelanggan" class="btn btn-primary">Add</a>
    </div>

    <div class="mt-3">
        <form action="{{ route('pelanggan') }}" method="GET" class="form-inline mt-3">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search by Name" value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="submit">Search</button>
                </div>
            </div>
        </form>
    </div>

    <div class="mt-5">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
    </div>

    <div class="my-5">
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>No.Telepon</th>
                    <th>Alamat</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pelanggan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->no_telepon }}</td>
                        <td>{{ $item->alamat }}</td>
                        <td>
                            <div class="action-buttons">
                                <form action="{{ route('edit-pelanggan', $item->id) }}">
                                    <button type="submit" class="btn btn-link"><i class="bi bi-pencil"></i></button>
                                </form>
                                <form action="{{ route('delete-pelanggan', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link" onclick="return confirmDelete();"><i class="bi bi-trash3-fill"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
@endsection

@section('scripts')
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this data?');
        }
    </script>
@endsection
