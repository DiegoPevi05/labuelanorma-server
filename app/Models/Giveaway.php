<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Giveaway extends Model
{
    use HasFactory;

    protected $table = 'giveaways';

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'image_url',
        'user_winner_id'
    ];
}
