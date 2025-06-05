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
                        <th class="text-center">Kasir</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Tgl Pembelian</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($result as $row)
                    <tr>
                        <td class="text-center">{{ $row->order_id}}</td>
                        <td class="text-center">{{ $row->users->username}}</td>
                        <td class="text-center">Rp {{ number_format($row->total, 0, ',', '.') }}</td>
                        <td class="text-center">{{ $row->created_at->format('d M Y H:i') }}</td>
                        <td class="text-center">
                            <a href="{{ url('transaksi/detail') }}" data-id="{{ $row->order_id }}" class="btn btn-success"> Detail</a>
                        </td>
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