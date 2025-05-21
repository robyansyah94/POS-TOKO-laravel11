<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // public function up(): void
    // {
    //     Schema::table('order_detail', function ($table) {
    //         // Tambahkan kolom order_id
    //         $table->unsignedInteger('order_id')->after('id_order_detail');

    //         // Tambahkan kolom produk_id (mengacu ke tabel t_produk)
    //         $table->unsignedInteger('id_produk')->after('order_id');

    //         // Tambahkan foreign key ke tabel order
    //         $table->foreign('order_id')->references('order_id')->on('order')->onDelete('cascade');

    //         // Tambahkan foreign key ke tabel t_produk
    //         $table->foreign('id_produk')->references('id_produk')->on('t_produk')->onDelete('restrict');
    //     });
    // }

    // public function down(): void
    // {
    //     Schema::table('order_detail', function ($table) {
    //         $table->dropForeign(['order_id']);
    //         $table->dropForeign(['id_produk']);
    //         $table->dropColumn(['order_id', 'id_produk']);
    //     });
    // }
};
