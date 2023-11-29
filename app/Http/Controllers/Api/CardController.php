<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\CardsService;
use App\Service\UserCardsService;

class CardController extends Controller
{

    public function __construct(
        private UserCardsService $userCardsService,
        private CardsService $cardsService
    )
    {

    }


    public function card()
    {
        $user = auth()->user();
        $card = $this->cardsService->getRandom();
        $this->userCardsService->create($user, $card->id);
        $userCards = $this->userCardsService->getCurrentCards($user);


        return response()->json($userCards);
    }
}
