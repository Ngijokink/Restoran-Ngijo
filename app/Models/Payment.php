<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    public $timestamps = true;

    protected $fillable = [
        'id_cart',
        'amount',
        'method',
        'status',
        'proof',
        'paid_at',
    ];

    public function cart()
    {
         return $this->belongsTo(Cart::class, 'id_cart', 'id_cart');
    }
}