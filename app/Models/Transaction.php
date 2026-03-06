<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'uuid';
    public $incrementing = false;       
    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
        'order_id',     
        'total',
        'method',       
        'status',
        'paid_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }

    public function order()
    {
        // note: orders table currently doesn't define transaction_id; if you
        // add the column later, make sure it stores a uuid and use this key
        return $this->hasOne(Orders::class, 'transaction_id', 'uuid');
    }
    
    public $timestamps = true;
}