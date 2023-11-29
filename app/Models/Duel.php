<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Duel extends Model
{
    use HasFactory;

    public const STATUS_ACTIVE = 1;

    public const STATUS_FINISHED = 2;

    protected $fillable = [
        'round',
        'status'
    ];

    public function duelPlayers():HasMany
    {
        return $this->hasMany(DuelPlayer::class, 'duel_id');
    }

    public function duelRounds():HasMany
    {
        return $this->hasMany(DuelRound::class, 'duel_id');
    }
}
