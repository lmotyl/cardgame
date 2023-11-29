<?php

namespace App\Repositories;

use App\Models\Duel;
use App\Models\DuelPlayer;
use App\Models\User;
use Illuminate\Support\Collection;

class DuelPlayerRepository
{

    public function create(Duel $duel, User $user)
    {
        $duelPlayer = new DuelPlayer();
        $duelPlayer->duel_id = $duel->id;
        $duelPlayer->user_id = $user->id;
        $duelPlayer->user_points = 0;
        $duelPlayer->save();

        return $duelPlayer;
    }

    public function get(Duel $duel): Collection
    {
        return DuelPlayer::where('duel_id', $duel->id)->get();
    }

    public function getByUser(Duel $duel, User $user): ?DuelPlayer
    {
        return DuelPlayer::where('duel_id', $duel->id)
            ->where('user_id', $user->id)
            ->first();
    }

    public function update(DuelPlayer $duelPlayer, array $data):bool
    {
        return $duelPlayer->update($data);
    }

}
