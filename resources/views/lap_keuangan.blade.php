@extends('layout.mainlayout')

@section('title', 'Laporan Keuangan')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Laporan Keuangan</h1>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Bulan</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($laporan as $bulan => $data)
                        <tr>
                            <td>{{ $bulan }}</td>
                            <td>
                                <a href="{{ url('laporan/'.$bulan) }}" class="btn btn-primary">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
