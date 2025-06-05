<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $primaryKey = 'order_id';

    protected $fillable = ['invoice', 'id_user', 'total'];

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'order_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
