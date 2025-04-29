<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'nama_produk'=>'Monitor',
            'harga'=>'1200000'
        ];

        DB::table('t_produk')->insert($data);

        $data = [
            'nama_produk'=>'Mouse',
            'harga'=>'175000'
        ];

        DB::table('t_produk')->insert($data);
    }
}
