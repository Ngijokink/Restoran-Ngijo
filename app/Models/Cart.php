<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Prompts\Table;

class Cart extends Model
{
    protected $table = 'carts';
    protected $primaryKey = 'id_cart';

    protected $fillable = [
        'id_order',
        'table_id',
        'user_id',
        'total_price',
    ];

    public function items()
    {
        return $this->hasMany(CartItem::class, 'id_cart', 'id_cart');
    }
    public function table()
    {
        return $this->belongsTo(Meja::class, 'table_id', 'id_table');
    }

}