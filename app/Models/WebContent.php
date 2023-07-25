<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebContent extends Model
{
    use HasFactory;

    protected $table = 'web_contents';

    protected $fillable = [
        'section',
        'sub_section',
        'content_type',
        'content'
    ];
}
