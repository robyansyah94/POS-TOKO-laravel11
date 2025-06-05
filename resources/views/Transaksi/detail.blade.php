@extends('templates/header')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <h1>Detail Transaksi</h1><small>MarketBy</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ ('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Data Kategori</li>
        <li class="active">{{ empty($result) ? 'Tambah' : 'Edit' }} Tambah Data Kategori</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    @include('templates/feedback')

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <a href="{{ url('/transaksi') }}" class="btn bg-purple"><i class="fa fa-chevron-left"></i> Kembali</a>
        </div>
        <div class="box-body">
            <!-- {{ csrf_field() }}

                @if (!empty($result))
                {{ method_field('patch') }}
                @endif -->
        </div>
        <!-- /.box-body -->
        <!-- /.box-footer-->
    </div>
    <!-- /.box -->

</section>
<!-- /.content -->
@endsection