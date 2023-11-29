<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DuelUsedCards extends Model
{
    use HasFactory;

    protected $fillable = [
        'duel_id',
        'duel_player_id',
        'card_id'
    ];

}
