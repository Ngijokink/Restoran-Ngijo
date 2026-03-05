<?php
namespace App\Models;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'id_orders';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'total_price',
        'status',
        'order_code',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id_orders) {
                $model->id_orders = self::generateRandomNumber();
            }
        });
    }

    private static function generateRandomNumber()
    {
        do {
            $number = random_int(1000000000, 9999999999);
        } while (self::where('id_orders', $number)->exists());

        return $number;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}