@extends('layout.mainlayout')

@section('title', 'Pelanggan')

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
        <div class="d-flex justify-content-center">
            {{ $pelanggan->links('pagination::bootstrap-4') }}
        </div>
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
