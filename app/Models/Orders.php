<?php
namespace App\Models;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $primaryKey = 'id_order';
    public $incrementing = false;
    protected $keyType = 'int';
    protected $table = 'table_orders';

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
            if (!$model->id_order) {
                $model->id_order = self::generateRandomNumber();
            }
        });
    }

    private static function generateRandomNumber()
    {
        do {
            $number = random_int(1000000000, 9999999999);
        } while (self::where('id_order', $number)->exists());

        return $number;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}