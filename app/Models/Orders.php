<?php
namespace App\Models;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total_price',
        'status',
        'order_code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public $timestamps = true;
}