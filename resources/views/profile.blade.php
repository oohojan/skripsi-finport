@extends('layout.mainlayout')

@section('title', 'Profile')

@section('content')
    <div class="container">
        <h1>Profile Page</h1>

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
                <label for="nama">Name:</label>
                <input type="text" class="form-control" id="nama" value="{{ $user->Nama }}" readonly>
            </div>

            <div class="mt-3">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" value="{{ $user->email }}" readonly>
            </div>

            <div class="mt-3">
                <label for="no_telepon">Phone:</label>
                <input type="text" class="form-control" id="no_telepon" value="{{ $user->No_Telepon }}" readonly>
            </div>

            <div class="mt-3">
                <label for="address">Address:</label>
                <textarea class="form-control" id="address" rows="3" readonly>{{ $user->address }}</textarea>
            </div>

            <div class="mt-3">
                <label for="role">Role:</label>
                <input type="text" class="form-control" id="role" value="{{ $user->role->name }}" readonly>
            </div>

            <div class="mt-3">
                <a href="{{ route('profile.edit') }}" class="btn btn-primary">Update Profile</a>
            </div>

        </div>


    </div>
@endsection
