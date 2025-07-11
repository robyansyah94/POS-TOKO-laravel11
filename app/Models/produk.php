<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class produk extends Model
{
    protected $primaryKey = 'id_produk';

    protected $table = 't_produk'; 

    protected $fillable = [
        'nama_produk', 'sku', 'stok', 'harga', 'id_kategori', 'foto'
    ];

    public function kategori()
    {
        return $this->hasOne('\App\Models\kategori', 'id_kategori', 'id_kategori');
    }
}
