<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $table = 'table_categories';
    protected $primaryKey = 'id_category';

    protected $fillable = [
        'category',
    ];

    public function menus()
    {
        return $this->hasMany(Menu::class, 'category_id', 'id_category');
    }
}