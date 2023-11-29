<?php

namespace App\Service;

use App\Dtos\LevelDto;
use App\Models\User;
use App\Models\UserScore;
use Illuminate\Support\Collection;

class LevelService
{
    private Collection $configLevels;
    public function __construct()
    {
        $this->configLevels = collect(config('game.levels'));
    }

    public function currentLevel(User $user): LevelDto
    {
        $userScore = $user->userScore()->first();
        $currentLevel = $this->configLevels->first(function($item) use ($userScore) {
            return $userScore->level == $item['level'];
        });
        $levelDto = new LevelDto();
        $levelDto->level = $currentLevel['level'];
        $levelDto->cardsCount = $currentLevel['cards'];
        $levelDto->scoreMax = $currentLevel['score_max'];

        return $levelDto;
    }

    public function getLevelByScore(UserScore $userScore)
    {
        $index = $this->configLevels->search(function($item) use ($userScore) {
            return $userScore->score > $item['score_max'];
        });
        $currentLevel = $this->configLevels[$index];

        $levelDto = new LevelDto();
        $levelDto->level = $currentLevel['level'];
        $levelDto->cardsCount = $currentLevel['cards'];
        $levelDto->scoreMax = $currentLevel['score_max'];

        return $levelDto;
    }


}
