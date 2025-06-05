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

    <!-- Modal Detail Transaksi -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><b>Detail Transaksi</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body-detail">
                    <!-- Konten detail akan dimuat di sini -->
                    <div class="text-center">Loading...</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
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
                            <button class="btn btn-success btn-detail" data-id="{{ $row->order_id }}">Detail</button>
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

@section('scripts')
<script>
$(document).ready(function() {
    $('.btn-detail').click(function() {
        var orderId = $(this).data('id');

        // Tampilkan modal dengan loading
        $('#modal-body-detail').html('<div class="text-center">Loading...</div>');
        $('#detailModal').modal('show');

        // AJAX untuk ambil detail transaksi
        $.ajax({
            url: '/transaksi/detail/' + orderId,
            method: 'GET',
            success: function(response) {
                $('#modal-body-detail').html(response.html);
            },
            error: function() {
                $('#modal-body-detail').html('<p class="text-danger">Terjadi kesalahan saat memuat data.</p>');
            }
        });
    });
});
</script>
@endsection
