<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Giveaway_participants extends Model
{
    use HasFactory;

    protected $table = 'giveaway_particpants';

    protected $fillable = [
        'giveaway_id',
        'user_id',
    ];
}
