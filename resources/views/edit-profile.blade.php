@extends('layout.mainlayout')

@section('title', 'Edit Profile')

@section('content')
    <div class="container">
        <h1>Edit Profile</h1>

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

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mt-3">
                <label for="nama">Name:</label>
                <input type="text" class="form-control" id="nama" name="nama" value="{{ $user->Nama }}" required>
            </div>

            <div class="mt-3">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" >
            </div>

            <div class="mt-3">
                <label for="no_telepon">Phone:</label>
                <input type="text" class="form-control" id="no_telepon" name="no_telepon" value="{{ $user->No_Telepon }}" >
            </div>

            <div class="mt-3">
                <label for="address">Address:</label>
                <textarea class="form-control" id="address" name="address" rows="3" >{{ $user->address }}</textarea>
            </div>

            <div class="mt-3">
                <label for="password">Create New Password:</label>
                <input type="password" class="form-control" id="password" name="password" value="" >
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('profile') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
