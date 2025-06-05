<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($details as $item)
        <tr>
            <td>{{ $item->produk->nama_produk ?? 'Produk tidak ditemukan' }}</td>
            <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
            <td>{{ $item->jumlah }}</td>
            <td>Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
