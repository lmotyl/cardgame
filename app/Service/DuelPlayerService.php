<?php

namespace App\Service;

use App\Dtos\CardDto;
use App\Models\Duel;
use App\Models\DuelPlayer;
use App\Models\User;
use App\Repositories\DuelPlayerRepository;
use Illuminate\Support\Collection;

class DuelPlayerService
{
    public function __construct(
        private DuelPlayerRepository $duelPlayerRepository
    )
    {

    }

    public function create(Duel $duel, User $user)
    {
        return $this->duelPlayerRepository->create($duel, $user);;
    }

    public function getByUser(Duel $duel, User $user): ?DuelPlayer
    {
        return $this->duelPlayerRepository->getByUser($duel, $user);
    }

    public function getOpponentByUser(Duel $duel, User $user): ?DuelPlayer
    {
        $duelPlayers = $this->duelPlayerRepository->get($duel);
        $index =  $duelPlayers->search(function ($item) use ($user) {
            return $item->user_id != $user->id;
        });

        return $duelPlayers[$index];
    }

    public function get(Duel $duel): ?Collection
    {
        return $this->duelPlayerRepository->get($duel);
    }

    public function addPoints(DuelPlayer $duelPlayer, int $points)
    {
        return $this->duelPlayerRepository->update($duelPlayer, [
            'user_points' => $duelPlayer->user_points + $points
        ]);
    }

}
