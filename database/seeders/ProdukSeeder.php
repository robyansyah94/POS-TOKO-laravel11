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
            'nama_produk'=>'Ciki',
            'stok'=>'4',
            'harga'=>'6500.00',
        ];

        DB::table('t_produk')->insert($data);
    }
}
