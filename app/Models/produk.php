<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class produk extends Model
{
    protected $primaryKey = 'id_produk';

    protected $table = 't_produk';

    protected $fillable = [
        'nama_produk', 'harga' , 'stok'
    ];
}
