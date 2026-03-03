<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'id';
    
    protected $fillable = [
    ];

    public function order()
    {
        return $this->hasOne(Order::class, 'transaction_id', 'id');
    }
}