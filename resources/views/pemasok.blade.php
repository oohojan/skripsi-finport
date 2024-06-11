@extends('layout.mainlayout')

@section('title', 'Pemasok')

@section('content')
    <h1>
        List Pemasok
    </h1>

    <div class="mt-5 d-flex justify-content-end">
        <a href="add-pemasok" class="btn btn-primary">Add</a>
    </div>

    <div class="mt-5">
        @if (session('status'))
            <div class="alert alert-success">
                {{session('status')}}
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
                    <th>Keterangan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pemasok as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->no_telepon}}</td>
                        <td>{{$item->alamat}}</td>
                        <td>{{$item->keterangan}}</td>
                        <td>
                            <div class="action-buttons">
                                <form action="{{ route('edit-pemasok', $item->id) }}">
                                    <button type="submit" class="btn btn-link"><i class="bi bi-pencil"></i></button>
                                </form>
                                <form action="{{ route('delete-pemasok', $item->id) }}" method="POST">
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
@endsection

    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this data?');
        }
    </script>
