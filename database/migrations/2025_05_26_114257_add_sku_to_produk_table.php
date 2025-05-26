<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('t_produk', function (Blueprint $table) {
            $table->string('sku')->unique()->after('id_produk');
        });
    }

    public function down()
    {
        Schema::table('t_produk', function (Blueprint $table) {
            $table->dropColumn('sku');
        });
    }
};
