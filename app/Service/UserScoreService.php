<?php

namespace App\Service;

use App\Models\User;
use App\Models\UserScore;

class UserScoreService
{

    public function __construct(
        private LevelService $levelService
    ) {

    }

    public function promoteWinner(User $user)
    {
        $params = config('game.params');
        $levels = config('game.levels');
        $userScore = $user->userScore()->first();
        $currentLevel = $this->levelService->currentLevel($userScore);

        $userScore->score += $params['scoreForWin'];
        $userScore->level = $currentLevel->level;
        $userScore->save();
    }

}
