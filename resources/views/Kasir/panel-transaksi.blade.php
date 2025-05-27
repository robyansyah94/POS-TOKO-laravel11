@php
$keranjang = session('keranjang', []);
@endphp

@foreach($keranjang as $id => $item)
<div class="cart-item" data-harga="{{ $item['harga'] }}" data-jumlah="{{ $item['jumlah'] }}">
    <strong>{{ $item['nama_produk'] }}</strong><br>
    <small>Rp {{ number_format($item['harga'], 0, ',', '.') }} | Stok: {{ $item['stok'] }}</small>
    <div class="row" style="margin-top: 10px;">
        <div class="col-xs-8">
            <div class="input-group input-group-sm">
                <span class="input-group-btn">
                    <button data-id="{{ $id }}" class="btn btn-default btn-kurang">-</button>
                </span>
                <input type="text" class="form-control text-center" value="{{ $item['jumlah'] }}" readonly>
                <span class="input-group-btn">
                    <button data-id="{{ $id }}" class="btn btn-default btn-tambah">+</button>
                </span>
            </div>
        </div>
        <div class="col-xs-4 text-right">
            <strong>Rp {{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}</strong>
        </div>
    </div>
    <br>
</div>
@endforeach

@if(count($keranjang))
<button id="btn-hapus-semua" class="btn btn-danger btn-block btn-sm">Hapus Semua</button>
<hr>
@endif

<p><strong>Sub Total:</strong> <span class="pull-right" id="subtotal">Rp 0</span></p>
<p>Pajak (11%): <span class="pull-right" id="pajak">Rp 0</span></p>
<hr>
<h4><strong>Total:</strong> <span class="pull-right text-purple" id="total">Rp 0</span></h4>
<hr>

<form action="{{ route('keranjang.bayar') }}" method="POST">
    <div class="form-group">
        <label for="uang_diberikan">Uang Diberikan</label>
        <input type="text" id="uang_diberikan" name="uang_diberikan" class="form-control"
            placeholder="Masukkan jumlah uang"
            oninput="this.value = this.value.replace(/[^0-9]/g, ''); hitungKembalian();">
    </div>

    <div class="form-group">
        <label for="kembalian">Kembalian</label>
        <input type="text" id="kembalian" class="form-control" readonly>
    </div>

    @csrf
    <!-- elemen input dan keranjang -->
    <button class="btn btn-success btn-lg btn-block" type="submit">
        <strong>Bayar</strong>
    </button>
</form>