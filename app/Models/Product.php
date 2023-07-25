<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'details',
        'price',
        'category_id',
        'image_url_1',
        'image_url_2',
        'image_url_3',
        'image_url_4'
    ];
}
