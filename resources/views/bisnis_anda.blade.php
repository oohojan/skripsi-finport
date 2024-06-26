@extends('layout.mainlayout')

@section('title', 'Bisnis Anda')

@section('content')
    <h1>UMKM Anda</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="mt-5">
        <div class="mt-3">
            <label for="nama_umkm">Nama UMKM:</label>
            <input type="text" class="form-control" id="nama_umkm" value="{{ $umkm->nama_umkm }}" readonly>
        </div>

        <div class="mt-3">
            <label for="alamat_umkm">Alamat UMKM:</label>
            <input type="text" class="form-control" id="alamat_umkm" value="{{ $umkm->alamat_umkm }}" readonly>
        </div>

        <div class="mt-3">
            <a href="{{ route('bisnis.edit', $umkm->id) }}" class="btn btn-primary">Update UMKM</a>
            <a href="{{ route('barang.index', $umkm->id) }}" class="btn btn-secondary">Stock Barang</a>
        </div>

        <h2 class="mt-5">Manage Employees</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Employee</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $employee->user->Nama }}</td>
                    <td>{{ $employee->user->email }}</td>
                    <td>
                        @if ($employee->status == 'pending')
                            <form action="{{ route('update-employee-status', $employee->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" name="status" value="accepted" class="btn btn-success">Accept</button>
                                <button type="submit" name="status" value="declined" class="btn btn-danger">Decline</button>
                            </form>
                        @elseif ($employee->status == 'accepted')
                            <button type="button" class="btn btn-success" disabled>Accepted</button>
                        @elseif ($employee->status == 'declined')
                            <button type="button" class="btn btn-danger" disabled>Declined</button>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
