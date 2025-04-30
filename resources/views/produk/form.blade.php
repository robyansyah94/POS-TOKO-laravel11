@extends('templates/header')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{ empty($result) ? 'Tambah' : 'Edit' }} Data produk
        <small>SMK Negeri 1 Cianjur</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ ('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Data produk</li>
        <li class="active">{{ empty($result) ? 'Tambah' : 'Edit' }} Tambah Data produk</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    @include('templates/feedback')

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <a href="{{ url('/') }}" class="btn bg-purple"><i class="fa fa-chevron-left"></i> Kembali</a>
        </div>
        <div class="box-body">
            <form action="{{ empty($result) ? url('produk/add') : url("produk/$result->id_produk/edit") }}" class="form-horizontal" method="POST">
                {{ csrf_field() }}

                @if (!empty($result))
                {{ method_field('patch') }}
                @endif
                <div class="form-group">
                    <label class="control-label col-sm-2">Nama Produk</label>
                    <div class="col-sm-10">
                        <input type="text" name="nama_produk" class="form-control" placeholder="Masukkan Nama produk" value="{{ @$result->nama_produk }}" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2">Stok</label>
                    <div class="col-sm-10">
                        <input type="text" name="stok" class="form-control" placeholder="Masukkan Stok" value="{{ @$result->stok }}" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2">Harga</label>
                    <div class="col-sm-10">
                        <input type="text" name="harga" class="form-control" placeholder="Masukkan Harga" value="{{ @$result->harga }}" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2">Kategori</label>
                    <div class="col-sm-10">
                        <select name="id_kategori" class="form-control">
                        @foreach(\App\Models\kategori::all() as $kategori)
                            <option value="{{ $kategori->id_kategori }}" {{ @$result->id_kategori == $kategori->id_kategori ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-10 col-sm-offset-2">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box-body -->
        <!-- /.box-footer-->
    </div>
    <!-- /.box -->

</section>
<!-- /.content -->
@endsection