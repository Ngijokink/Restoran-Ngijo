<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'table_menus';
    protected $primaryKey = 'id_menu';

    protected $fillable = [
        'category_id',
        'name',
        'price',
        'stock',
        'is_available',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id_category');
    }
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'id_menu', 'id_menu');
    }
}