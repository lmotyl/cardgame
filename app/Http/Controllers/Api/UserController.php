<?php

namespace App\Http\Controllers\Api;

use App\Dtos\UserDataDto;
use App\Http\Controllers\Controller;
use App\Service\UserService;

class UserController extends Controller
{

    public function __construct(
        private UserService $userService
    ) {

    }

    public function data()
    {
        $user = auth()->user();
        $userScore = $user->userScore()->first();
        $levelsConfig = collect(config('game.levels'));

        $userCurrentLevelConfig = $levelsConfig->first(function($item) use ($userScore) {
            return $userScore->level == $item['level'];
        });

        $userDataDto = $this->userService->data($user, new UserDataDto());

        return response()->json(
            [
                'id' => $user->id,
                'username' => $user->name,
                'level' => $userScore->level,
                'level_points' => $userScore->score . '/' . $userCurrentLevelConfig['score_max'],
                'cards' => $userDataDto->cards,
                'new_card_allowed' => $userDataDto->newCardAllowed,
            ]
        );
    }

}
