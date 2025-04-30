<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kategori extends Model
{
    protected $primaryKey = 'id_kategori';

    protected $table = 't_kategori';

    protected $fillable = [
        'nama_kategori', 'deskripsi'
    ];
}
