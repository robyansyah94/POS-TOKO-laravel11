<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Setelah yakin semua data valid, baru tambahkan foreign key
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }
};
