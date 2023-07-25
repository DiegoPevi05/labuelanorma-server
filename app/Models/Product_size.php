<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product_size extends Model
{
    use HasFactory;

    protected $table = 'product_sizes';

    protected $fillable = [
        'type',
        'name',
        'stock',
        'price',
        'product_id'
    ];
}
