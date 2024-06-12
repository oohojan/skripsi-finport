@extends('layout.mainlayout')

@section('title', 'Profile')

@section('content')
    <h1>ini halaman profile</h1>
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
@endsection
