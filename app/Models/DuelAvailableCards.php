<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DuelAvailableCards extends Model
{
    use HasFactory;

    protected $fillable = [
        'duel_id',
        'duel_player_id',
        'card_id'
    ];

    public function duelPlayer()
    {
        return $this->belongsTo(DuelPlayer::class, 'duel_player_id');
    }

    public function duel()
    {
        return $this->belongsTo(Duel::class, 'duel_id');
    }

}
