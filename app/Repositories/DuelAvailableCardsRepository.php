<?php

namespace App\Repositories;

use App\Models\Duel;
use App\Models\DuelAvailableCards;
use App\Models\DuelPlayer;
use App\Models\User;
use App\Models\UserCards;
use Illuminate\Database\Eloquent\Collection;

class DuelAvailableCardsRepository
{

    public function create(Duel $duel, DuelPlayer $duelPlayer, int $cardId)
    {
        $duelAvailableCards = new DuelAvailableCards();
        $duelAvailableCards->duelPlayer()->associate($duelPlayer);
        $duelAvailableCards->duel()->associate($duel);
        $duelAvailableCards->card_id = $cardId;
        $duelAvailableCards->save();

        return $duelAvailableCards;
    }

    public function random(Duel $duel, DuelPlayer $duelPlayer):?DuelAvailableCards
    {
        return DuelAvailableCards::where('duel_id', $duel->id)
            ->where('duel_player_id', $duelPlayer->id)
            ->get()
            ->random();
    }

    public function get(Duel $duel, DuelPlayer $duelPlayer):Collection
    {
        return DuelAvailableCards::where('duel_id', $duel->id)
            ->where('duel_player_id', $duelPlayer->id)
            ->get();
    }

    public function remove(Duel $duel, DuelPlayer $duelPlayer, int $cardId): ?bool
    {
        /** @var DuelAvailableCards $duelAvailableCard */
        $duelAvailableCard = DuelAvailableCards::where('duel_id', $duel->id)
            ->where('duel_player_id', $duelPlayer->id)
            ->where('card_id', $cardId)
            ->first();

        return $duelAvailableCard->delete();
    }
}
