<?php

namespace App\Service;

use App\Dtos\LevelDto;
use App\Models\User;
use App\Repositories\UserCardsRepository;

class UserCardsService
{
    public function __construct(
        private UserCardsRepository $userCardsRepository,
        private CardsService $cardsService,
        private LevelService $levelService
    ) {

    }

    public function getCurrentCards(User $user)
    {
        $userCards = $this->userCardsRepository->currentByUser($user);;
        return $userCards->map(function($item) {
            return $this->cardsService->getById($item['card_id']);
        });
    }

    public function create(User $user, $cardId)
    {
        return $this->userCardsRepository->create($user, $cardId);
    }

    public function findRandom(User $user)
    {

    }

    public function pickCardsByLevelDto(User $user, LevelDto $levelDto)
    {
        $userCards = $this->getCurrentCards($user);

        for ($i = $userCards->count(); $i < $levelDto->cardsCount; $i++) {
            $card = $this->cardsService->getRandom();
            $this->create($user, $card->id);
        }
    }

    public function isNewCardAllowed(User $user)
    {
        $userCards = $this->userCardsRepository->currentByUser($user);
        $currentLevel = $this->levelService->currentLevel($user);

        return !$userCards->count() || $userCards->count() < $currentLevel->cardsCount;
    }
}
