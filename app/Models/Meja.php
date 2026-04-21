<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    use HasFactory;

    protected $table = 'table_meja';
    protected $primaryKey = 'id_table';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'table_number',
        'qr_code',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($meja) {

            $last = Meja::orderBy('id_table', 'desc')->first();

            if ($last) {
                $number = (int) substr($last->table_number, 4) + 1;
            } else {
                $number = 1;
            }

            $meja->table_number = 'TBL_' . str_pad($number, 3, '0', STR_PAD_LEFT);
        });
    }
}
