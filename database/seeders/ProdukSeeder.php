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
            'nama_kategori'=>'Sanack',
            'deskripsi'=>'Makanan ringan atau cemilan'
        ];

        DB::table('t_kategori')->insert($data);

        $data = [
            'nama_kategori'=>'Alat Mandi',
            'deskripsi'=>'Peralatan yang digunakan untuk mandi'
        ];

        DB::table('t_kategori')->insert($data);

        $data = [
            'nama_kategori'=>'Makanan Berat',
            'deskripsi'=>'jenis makanan yang mengandung energi tinggi dan sebagai hidangan utama'
        ];

        DB::table('t_kategori')->insert($data);
    }
}
