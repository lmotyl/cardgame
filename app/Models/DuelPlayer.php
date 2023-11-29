<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DuelPlayer extends Model
{
    use HasFactory;

    protected $fillable = [
        'duel_id',
        'user_id',
        'user_points'
    ];

    public function duel():BelongsTo
    {
        return $this->belongsTo(Duel::class, 'duel_id');
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
