<?php

namespace App\Repositories;

use App\Models\Duel;
use App\Models\User;

class DuelRepository
{

    public function currentByUser(User $user)
    {
        return Duel::with('duelPlayers')
            ->whereHas('duelPlayers', function($builder) use ($user) {
                $builder->where('user_id', $user->id);
            })
            ->where('duels.status', Duel::STATUS_ACTIVE)
            ->get()->first();
    }

    public function create()
    {
        $duel = new Duel();
        $duel->round = 1;
        $duel->status = Duel::STATUS_ACTIVE;
        $duel->save();

        return $duel;
    }

    public function update(Duel $duel, int $round, int $status)
    {
        $duel->update([
            'round' => $round,
            'status' => $status
        ]);
    }

    public function getFinished(): \Illuminate\Database\Eloquent\Collection
    {
        return Duel::with(['duelPlayers'])
            ->where('duels.status', Duel::STATUS_FINISHED)
            ->orderBy('duels.updated_at', 'desc')
            ->get();
    }
}
