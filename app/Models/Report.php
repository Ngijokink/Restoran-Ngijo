<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'reports';
    protected $primaryKey = 'id';

    protected $fillable = [
        'report_date',
        'total_orders',
        'total_order_revenue',
        'order_status_breakdown',
        'total_transactions',
        'total_success_amount',
        'total_per_method',
    ];
    public $timestamps = true;
    
}