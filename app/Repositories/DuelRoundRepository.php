<?php

namespace App\Repositories;

use App\Dtos\CardDto;
use App\Models\Duel;
use App\Models\DuelPlayer;
use App\Models\DuelRound;

class DuelRoundRepository
{
    public function create(Duel $duel, DuelPlayer $duelPlayer, CardDto $card)
    {
        $duelRound = new DuelRound();
        $duelRound->round = $duel->round;
        $duelRound->duel_id = $duel->id;
        $duelRound->duel_player_id = $duelPlayer->id;
        $duelRound->card_id = $card->id;
        $duelRound->score = $card->power;
        $duelRound->save();

        return $duelRound;
    }

    public function get(Duel $duel)
    {
        return DuelRound::where('duel_id', $duel->id)
            ->get();
    }
}
