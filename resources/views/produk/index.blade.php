@extends('templates/header')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Data Produk
        <small>TOko ELectronik</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Data Produk</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <a href="{{ url('produk/add') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Tambah</a>
        </div>
        <div class="box-body">
            <table class="table table-stripped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Stock</th>
                        <th>Harga</th>
                        <th>Kategori</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($result as $row)
                    <tr>
                        <td>{{ !empty($i) ? ++$i : $i = 1 }}</td>
                        <td>{{ $row->nama_produk }}</td>
                        <td>{{ $row->stok }}</td>
                        <td>{{ $row->kategori->nama_kategori }}</td>
                        <td>{{ $row->harga }}</td>
                        <td>
                            <a href="{{ url("produk/$row->id_produk/edit") }}" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a>
                            <form action="{{ url("produk/$row->id_produk/delete") }}" method="POST" style="display:inline;">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                            </form>
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