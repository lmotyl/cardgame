<?php

namespace App\Service;

use App\Dtos\LevelDto;
use App\Dtos\UserDataDto;
use App\Models\User;
use App\Models\UserScore;
use App\Models\UserType;
use App\Repositories\UserRepository;

class UserService
{

    public function __construct(
        private UserCardsService $userCardsService,
        private UserRepository $userRepository
    ) {

    }

    public function data(User $user, UserDataDto $userDataDto)
    {
        $userScore = $user->userScore()->first();

        $userDataDto->id = $user->id;
        $userDataDto->username = $user->name;
        $userDataDto->level = $userScore->level;
        $userDataDto->score = $userScore->score;
        $userDataDto->cards = $this->userCardsService->getCurrentCards($user);
        $userDataDto->newCardAllowed = $this->userCardsService->isNewCardAllowed($user);

        return $userDataDto;
    }

    public function getRandomByType(int $type, LevelDto $levelDto)
    {
        $randomUser = $this->userRepository->getRandomByType($type, $levelDto);
        return $randomUser;
    }

    public function createRandomOpponent(LevelDto $level)
    {
        $user = User::factory()
            ->has(UserType::factory()->state(['type' => UserType::TYPE_CPU]))
            ->has(UserScore::factory()->state(['level' => $level->level]))
            ->create()
        ;
        return $user;
    }


    public function updateUserScore()
    {


    }
}
