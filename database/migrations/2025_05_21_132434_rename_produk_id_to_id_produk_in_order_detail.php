<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_detail', function (Blueprint $table) {
            // Rename kolom produk_id jadi id_produk
            $table->renameColumn('produk_id', 'id_produk');

            // Tambahkan foreign key baru ke t_produk(id_produk)
            $table->foreign('id_produk')->references('id_produk')->on('t_produk')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::table('order_detail', function (Blueprint $table) {
            // Hapus foreign key dulu
            $table->dropForeign(['id_produk']);

            // Rename kembali kolom id_produk ke produk_id
            $table->renameColumn('id_produk', 'produk_id');
        });
    }
};
