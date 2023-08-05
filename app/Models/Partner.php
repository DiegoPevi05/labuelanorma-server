<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;
    
    use HasFactory;

    protected $table = 'partners';

    protected $fillable = [
        'name',
        'description',
        'image_brand',
        'link_content',
        'brand_link',
        'tags',
    ];
}
