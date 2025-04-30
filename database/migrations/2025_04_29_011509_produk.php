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
        Schema::create('t_produk', function (Blueprint $table) {
            $table->increments('id_produk');
            $table->string('nama_produk', 100);
            $table->integer('stok');
            $table->decimal('harga', 10, 2);
            $table->integer('id_kategori');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_produk');
    }
};
