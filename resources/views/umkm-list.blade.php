@extends('layout.mainlayout')

@section('title', 'UMKM List')

@section('content')
    <h1>Join UMKM</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('umkm-list') }}" method="GET" class="mt-3">
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="search" placeholder="Search by Nama Toko" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <div class="my-5">
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Toko</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($umkm as $item)
                    <tr>
                        <td>{{ $loop->iteration + $umkm->firstItem() - 1 }}</td>
                        <td>{{ $item->nama_umkm }}</td>
                        <td>
                            <form action="{{ route('join-umkm', $item->id) }}" method="POST" id="form-{{ $item->id }}">
                                @csrf
                                <button type="button" class="btn btn-primary join-button" onclick="confirmJoin({{ $item->id }})">Join</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $umkm->links() }}
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        function confirmJoin(id) {
            if (confirm('Apakah Anda yakin untuk bergabung dengan UMKM ini?')) {
                $('#form-' + id).submit();
            }
        }
    </script>
@endsection
