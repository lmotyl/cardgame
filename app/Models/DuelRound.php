<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DuelRound extends Model
{
    use HasFactory;

    protected $fillable = [
        'round',
        'duel_id',
        'duel_player_id',
        'score'
    ];
}
