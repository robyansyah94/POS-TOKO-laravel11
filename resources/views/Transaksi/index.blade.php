@extends('templates/header')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Transaksi
        <small>MarketBy</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Transaksi</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
@include('templates/feedback')

    <!-- Default box -->
    <div class="box">
        <div class="box-body">
            <table class="table table-stripped">
                <thead>
                    <tr>
                        <th class="text-center">No Order</th>
                        <th class="text-center">Nama Produk</th>
                        <th class="text-center">Harga</th>
                        <th class="text-center">Jumlah Beli</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Tgl Pembelian</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($result as $row)
                    <tr>
                        <td class="text-center">{{ $row->order_id}}</td>
                        <td class="text-center">{{ $row->produk->nama_produk }}</td>
                        <td class="text-center"><strong>Rp {{ number_format($row->harga, 0, ',', '.') }}</strong></td>
                        <td class="text-center">{{ $row->jumlah }}</td>
                        <td class="text-center">{{ $row->order->total }}</td>
                        <td class="text-center">{{ $row->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
        <!-- /.box-footer-->
    </div>
    <!-- /.box -->

</section>
<!-- /.content -->
@endsection