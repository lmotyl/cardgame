<?php

namespace App\Service;

use App\Models\Duel;
use App\Models\DuelPlayer;
use App\Repositories\DuelUsedCardsRepository;

class DuelUsedCardsService
{

    public function __construct(
        private DuelUsedCardsRepository $duelUsedCardsRepository
    )
    {

    }

    public function create(Duel $duel, DuelPlayer $duelPlayer, int $cardId)
    {
        return $this->duelUsedCardsRepository->create($duel, $duelPlayer, $cardId);
    }
}
