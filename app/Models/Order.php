<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'order_number',
        'user_id',
        'status',
        'discount_code_id',
        'calculated_amount',
        'gross_import',
        'discount_amount',
        'net_import',
    ];

}
