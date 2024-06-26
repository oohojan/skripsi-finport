@extends('layout.mainlayout')

@section('title', 'Manage Employees')

@section('content')
    <h1>Manage Employees</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="my-5">
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
                        <td>{{ $employee->user->nama }}</td>
                        <td>{{ $employee->user->email }}</td>
                        <td>
                            <form action="{{ route('update-employee-status', $employee->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" name="status" value="accepted" class="btn btn-success">Accept</button>
                                <button type="submit" name="status" value="declined" class="btn btn-danger">Decline</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
