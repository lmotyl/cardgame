<?php

namespace App\Repositories;

use App\Dtos\LevelDto;
use App\Models\User;

class UserRepository
{

    public function getRandomByType(int $type, LevelDto $levelDto = null)
    {
        $query = User::select(['users.*', 'user_types.*', 'user_scores.level'])
            ->join('user_types', 'users.id', '=', 'user_types.user_id')
            ->join('user_scores', 'users.id', '=', 'user_scores.user_id')
            ->where('user_types.type', $type);

        if ($levelDto) {
            $query->where('user_scores.level', $levelDto->level);
        }

        return $query
            ->get()
            ->random();
    }
}
