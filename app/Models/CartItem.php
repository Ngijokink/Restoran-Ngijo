<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $primaryKey = 'id_cart_item';

    protected $fillable = [
        'cart_id',
        'menu_id',
        'qty',
        'price',
        'subtotal'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class,'menu_id');
    }
}