<?php

namespace App\Service;

use App\Dtos\CardDto;
use App\Models\Duel;
use App\Models\DuelPlayer;
use App\Models\User;
use App\Repositories\DuelAvailableCardsRepository;
use Illuminate\Support\Collection;

class DuelCardsService
{
    public function __construct(
        private DuelAvailableCardsRepository $duelAvailableCardsRepository,
        private CardsService                 $cardsService
    )
    {

    }

    public function setAvailableCards(Duel $duel, DuelPlayer $duelPlayer, Collection $cards)
    {
        $cards->each(function ($card) use ($duel, $duelPlayer) {
            $this->duelAvailableCardsRepository->create($duel, $duelPlayer, $card->id);
        });
    }

    public function getAvailableCards(Duel $duel, DuelPlayer $duelPlayer)
    {
        $duelCards = $this->duelAvailableCardsRepository->get($duel, $duelPlayer);

        return $duelCards->map(function ($card) use ($duel, $duelPlayer) {
           return $this->cardsService->getById($card->card_id);
        });
    }

    public function getRandom(Duel $duel, DuelPlayer $dualPlayer): CardDto
    {
        $duelCard = $this->duelAvailableCardsRepository->random($duel, $dualPlayer);
        return $this->cardsService->getById($duelCard->card_id);
    }

    public function pick(Duel $duel, DuelPlayer $duelPlayer, int $cardId)
    {
        return $this->duelAvailableCardsRepository->remove($duel, $duelPlayer, $cardId);
    }
}
