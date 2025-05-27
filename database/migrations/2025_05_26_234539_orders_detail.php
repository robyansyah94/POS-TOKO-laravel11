<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_detail', function (Blueprint $table) {
            $table->increments('id_order_detail');
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('id_produk');
            $table->integer('harga');
            $table->integer('jumlah')->default(1);
            $table->timestamps();

            $table->foreign('order_id')->references('order_id')->on('order')->onDelete('cascade');
            $table->foreign('id_produk')->references('id_produk')->on('t_produk')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_detail');
    }
};
