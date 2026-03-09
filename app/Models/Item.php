<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Orders;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $table = 'table_order_items';
    protected $primaryKey = 'id_order_item';

    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'id_order_item',
        'order_id',
        'menu_id',
        'quantity',
        'price',
        'subtotal'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id_order_item) {
                $model->id_order_item = self::generateRandomNumber();
            }
        });
    }

    private static function generateRandomNumber()
    {
        do {
            $number = random_int(1000000000, 9999999999);
        } while (self::where('id_order_item', $number)->exists());

        return $number;
    }

    public function order()
    {
        return $this->belongsTo(Orders::class, 'order_id', 'id_order');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id_menu');
    }

    public $timestamps = true;
}