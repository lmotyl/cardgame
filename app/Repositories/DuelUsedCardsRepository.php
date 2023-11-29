<?php

namespace App\Repositories;

use App\Models\Duel;
use App\Models\DuelPlayer;
use App\Models\DuelUsedCards;

class DuelUsedCardsRepository
{

    public function create(Duel $duel, DuelPlayer $duelPlayer, int $cardId):DuelUsedCards
    {
        $duelUsedCard = new DuelUsedCards();
        $duelUsedCard->duel_id = $duel->id;
        $duelUsedCard->duel_player_id = $duelPlayer->id;
        $duelUsedCard->card_id = $cardId;
        $duelUsedCard->save();

        return $duelUsedCard;
    }

}
