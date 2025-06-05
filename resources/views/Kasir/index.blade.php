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
                                    <p>Stok : {{ $produk->stok }}</p>
                                    <p><strong>Rp {{ number_format($produk->harga, 0, ',', '.') }}</strong></p>
                                    <p>
                                        @if ($produk->stok > 0)
                                    <form class="form-tambah" data-id="{{ $produk->id_produk }}">
                                        <button type="submit" class="btn btn-primary btn-sm">Tambah</button>
                                    </form>
                                    @else
                                    <button class="btn btn-secondary btn-sm" disabled>Habis</button>
                                    @endif
                                    </p>
                                </div>

                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Panel Transaksi (AJAX Loaded) -->
            <div class="col-md-4 col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong><i class="glyphicon glyphicon-shopping-cart"></i> Keranjang Belanja</strong>
                    </div>

                    <div class="panel-body" id="panel-transaksi">
                        <!-- Isi akan dimuat via AJAX -->
                        <div class="text-center">
                            <i class="fa fa-spinner fa-spin"></i> Memuat keranjang...
                        </div>
                    </div>
                </div>
            </div>

            <!-- Script AJAX -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const panel = document.getElementById('panel-transaksi');

                    function loadPanelTransaksi() {
                        fetch('{{ url("keranjang/panel") }}')
                            .then(res => res.text())
                            .then(html => {
                                panel.innerHTML = html;
                                hitungTotalDanPajak(); // <- ini set data-total-value
                                bindPanelEvents(); // <- ini baru hitungKembalian
                            });
                    }

                    function bindFormTambah() {
                        document.querySelectorAll('.form-tambah').forEach(form => {
                            form.addEventListener('submit', function(e) {
                                e.preventDefault();
                                const id = this.dataset.id;

                                fetch('{{ url("keranjang/add") }}', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Content-Type': 'application/json',
                                        'Accept': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        id_produk: id
                                    })
                                }).then(() => loadPanelTransaksi());
                            });
                        });
                    }

                    function bindPanelEvents() {
                        // Tombol tambah
                        document.querySelectorAll('.btn-tambah').forEach(btn => {
                            btn.addEventListener('click', function() {
                                const id = this.dataset.id;
                                fetch('/keranjang/tambah/' + id, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json'
                                    }
                                }).then(() => loadPanelTransaksi());
                            });
                        });

                        // Tombol kurang
                        document.querySelectorAll('.btn-kurang').forEach(btn => {
                            btn.addEventListener('click', function() {
                                const id = this.dataset.id;
                                fetch('/keranjang/kurang/' + id, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json'
                                    }
                                }).then(() => loadPanelTransaksi());
                            });
                        });

                        // Hapus semua
                        const btnHapusSemua = document.getElementById('btn-hapus-semua');
                        if (btnHapusSemua) {
                            btnHapusSemua.addEventListener('click', function() {
                                if (confirm('Yakin hapus semua keranjang?')) {
                                    fetch('/keranjang/hapus-semua', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Accept': 'application/json'
                                        }
                                    }).then(() => loadPanelTransaksi());
                                }
                            });
                        }

                        // Format dan hitung kembalian
                        const uangDiberikan = document.getElementById('uang_diberikan');
                        if (uangDiberikan) {
                            uangDiberikan.addEventListener('input', function() {
                                formatInputRupiah(this);
                                hitungKembalian();
                            });
                        }

                        hitungKembalian();
                    }

                    function formatRupiah(angka) {
                        return 'Rp ' + angka.toLocaleString('id-ID');
                    }

                    function hitungTotalDanPajak() {
                        let subtotal = 0;
                        const cartItems = document.querySelectorAll('.cart-item');

                        cartItems.forEach(item => {
                            const harga = parseInt(item.dataset.harga);
                            const jumlah = parseInt(item.dataset.jumlah);
                            subtotal += harga * jumlah;
                        });

                        const pajak = subtotal * 0.11;
                        const total = subtotal + pajak;

                        document.getElementById('subtotal').innerText = formatRupiah(subtotal);
                        document.getElementById('pajak').innerText = formatRupiah(pajak);
                        const totalElement = document.getElementById('total');
                        totalElement.innerText = formatRupiah(total);
                        totalElement.dataset.totalValue = total;

                        // Panggil hitungKembalian() di sini karena totalValue sudah di-set
                        hitungKembalian();
                    }

                    function hitungKembalian() {
                        const uangInput = document.getElementById('uang_diberikan');
                        const totalValue = parseInt(document.getElementById('total')?.dataset.totalValue || 0);
                        const kembalianInput = document.getElementById('kembalian');

                        if (uangInput && kembalianInput) {
                            const uang = parseInt(uangInput.value.replace(/[^0-9]/g, ''));

                            if (isNaN(uang)) {
                                kembalianInput.value = '';
                                return;
                            }

                            if (uang < totalValue) {
                                kembalianInput.value = 'Uang kurang';
                            } else {
                                const kembalian = uang - totalValue;
                                kembalianInput.value = formatRupiah(kembalian);
                            }
                        }
                    }

                    function formatInputRupiah(input) {
                        let angka = input.value.replace(/[^0-9]/g, '');
                        input.value = angka ? parseInt(angka).toLocaleString('id-ID') : '';
                    }

                    // Inisialisasi
                    bindFormTambah();
                    loadPanelTransaksi();
                });
            </script>
        </div>
    </div>
    </div>
    <!-- /.box -->
</section>
<!-- /.content -->
@endsection