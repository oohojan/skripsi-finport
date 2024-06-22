@extends('layout.mainlayout')

@section('title', 'Laporan Keuangan')

@section('content')
    <h1>Laporan Keuangan</h1>
    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporan as $bulan => $data)
                <tr>
                    <td>{{ $bulan }}</td>
                    <td>
                        <button onclick="location.href='{{ url('laporan/'.$bulan) }}'">View</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
