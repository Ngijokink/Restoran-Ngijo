<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Cart extends Model
{
    protected $table = 'carts';
    protected $primaryKey = 'id_cart';

    protected $fillable = [
        'user_id'
    ];

    public function items()
    {
        return $this->hasMany(CartItem::class, 'id_cart', 'id_cart');
    }

}