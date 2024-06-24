<table class="table">
    <thead>
        <tr>
            <th>No.</th>
            <th>Tanggal Transaksi</th>
            <th>Jenis Transaksi</th>
            <th>Nama Pelanggan</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @if ($transaksi->count() > 0)
            @foreach ($transaksi as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->tanggal_transaksi }}</td>
                    <td>{{ $item->jenis_transaksi }}</td>
                    <td>{{ $item->pelanggan->nama }}</td>
                    <td>
                        <a href="{{ route('transaksi-detail', ['id' => $item->id]) }}" class="btn btn-primary">Detail</a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="5" style="text-align: center">Tidak ada data transaksi hari ini.</td>
            </tr>
        @endif
    </tbody>
</table>
