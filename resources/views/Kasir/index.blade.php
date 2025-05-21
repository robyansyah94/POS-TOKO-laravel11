@extends('templates/header')

@section('content')
<!-- Content Header (Page header) -->
<style>
    .img-square-wrapper {
        width: 100%;
        padding-top: 100%;
        /* membuat rasio 1:1 */
        position: relative;
        overflow: hidden;
        background: #fff;
    }

    .img-square-wrapper img.img-square {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: contain;
        /* atau 'cover' jika ingin gambar penuh */
        background-color: #f5f5f5;
    }

    .btn-group {
        display: flex;
        justify-content: space-between;
        /* Membuat tombol tersebar rata */
        width: 100%;
        /* Menyesuaikan lebar agar tombol penuh */
    }
</style>
<section class="content-header">
    <h1>
        Orders
        <small>MarketBy</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Orders </li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    @include('templates/feedback')
    <!-- Default box -->
    <div class="box">
        <!-- /.box-header -->
        <div class="row">
            <!-- Kolom Kiri: Daftar Produk -->
            <div class="col-md-8">
                <div class="box-body">
                    @foreach($result->chunk(4) as $chunk)
                    <div class="row">
                        @foreach($chunk as $produk)
                        <div class="col-sm-6 col-md-3">
                            <div class="thumbnail">
                                <div class="img-square-wrapper">
                                    <img src="{{ asset('uploads/' . @$produk->foto) }}" alt="Produk" class="img-square img-responsive">
                                </div>
                                <div class="caption text-center">
                                    <h4>{{ $produk->nama_produk }}</h4>
                                    <p><strong>Rp {{ number_format($produk->harga, 0, ',', '.') }}</strong></p>
                                    <p>
                                    <form action="{{ url('keranjang/add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id_produk" value="{{ $produk->id_produk }}">
                                        <button type="submit" class="btn btn-primary btn-sm">Tambah</button>
                                    </form>
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Kolom Kanan: Panel Transaksi -->
            <div class="col-md-4 col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong><i class="glyphicon glyphicon-shopping-cart"></i> Keranjang Belanja</strong>
                    </div>

                    <div class="panel-body" id="panel-transaksi">
                        @php
                        $keranjang = session('keranjang', []);
                        @endphp
                        @foreach($keranjang as $id => $item)
                        <div class="cart-item" style="margin-bottom: 15px;" data-harga="{{ $item['harga'] }}" data-jumlah="{{ $item['jumlah'] }}">
                            <strong>{{ $item['nama_produk'] }}</strong><br>
                            <small>Rp {{ number_format($item['harga'], 0, ',', '.') }} | Stok: {{ $item['stok'] }}</small>
                            <div class="row" style="margin-top: 10px;">
                                <div class="col-xs-8">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-btn">
                                            <form action="{{ url('keranjang/kurang/'.$id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-default">-</button>
                                            </form>
                                        </span>
                                        <input type="text" class="form-control text-center" value="{{ $item['jumlah'] }}" readonly>
                                        <span class="input-group-btn">
                                            <form action="{{ url('keranjang/tambah/'.$id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-default">+</button>
                                            </form>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-xs-4 text-right">
                                    <strong>Rp {{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}</strong>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        @if(count($keranjang))
                        <form action="{{ url('keranjang/hapus-semua') }}" method="POST" onsubmit="return confirm('Yakin hapus semua keranjang?');">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-block btn-sm">Hapus Semua</button>
                            <hr>
                        </form>
                        @endif
                        <p><strong>Sub Total:</strong> <span class="pull-right" id="subtotal">Rp 0</span></p>
                        <p>Pajak (11%): <span class="pull-right" id="pajak">Rp 0</span></p>
                        <hr>
                        <h4><strong>Total:</strong> <span class="pull-right text-purple" id="total">Rp 0</span></h4>
                        <hr>
                    </div>
                    <form action="{{ route('keranjang.bayar') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="uang_diberikan">Uang Diberikan</label>
                            <input type="text" id="uang_diberikan" name="uang_diberikan" class="form-control" placeholder="Masukkan jumlah uang" oninput="formatInputRupiah(this); hitungKembalian();">
                        </div>

                        <div class="form-group">
                            <label for="kembalian">Kembalian</label>
                            <input type="text" id="kembalian" class="form-control" readonly>
                        </div>

                        <button class="btn btn-success btn-lg btn-block" type="submit">
                            <strong>Bayar</strong>
                        </button>
                    </form>
                </div>
            </div>

            <script>
                function formatRupiah(angka) {
                    return 'Rp ' + angka.toLocaleString('id-ID');
                }

                function hitungTotalDanPajak() {
                    let subtotal = 0;
                    const cartItems = document.querySelectorAll('.cart-item');

                    cartItems.forEach(item => {
                        const harga = parseInt(item.getAttribute('data-harga'));
                        const jumlah = parseInt(item.getAttribute('data-jumlah'));
                        subtotal += harga * jumlah;
                    });

                    const pajak = subtotal * 0.11;
                    const total = subtotal + pajak;

                    // Update ke DOM
                    document.getElementById('subtotal').innerText = formatRupiah(subtotal);
                    document.getElementById('pajak').innerText = formatRupiah(pajak);
                    document.getElementById('total').innerText = formatRupiah(total);

                    // Simpan total untuk hitung kembalian
                    document.getElementById('total').dataset.totalValue = total;
                }

                function hitungKembalian() {
                    const uangInput = document.getElementById('uang_diberikan').value;
                    const uang = parseInt(uangInput.replace(/[^0-9]/g, '')); // Hapus semua selain angka
                    const total = parseInt(document.getElementById('total').dataset.totalValue || 0);
                    const kembalianInput = document.getElementById('kembalian');

                    if (!isNaN(uang) && uang >= total) {
                        const kembalian = uang - total;
                        kembalianInput.value = formatRupiah(kembalian);
                    } else {
                        kembalianInput.value = 'Rp 0';
                    }
                }

                function formatInputRupiah(input) {
                    let angka = input.value.replace(/[^0-9]/g, '');
                    if (!angka) {
                        input.value = '';
                        return;
                    }
                    angka = parseInt(angka).toLocaleString('id-ID');
                    input.value = angka;
                }

                // Jalankan saat halaman selesai dimuat
                document.addEventListener('DOMContentLoaded', hitungTotalDanPajak);
            </script>
        </div>
    </div>
    </div>
    <!-- /.box -->
</section>
<!-- /.content -->
@endsection