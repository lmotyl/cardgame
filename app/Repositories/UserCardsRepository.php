<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserCards;
use Illuminate\Database\Eloquent\Collection;

class UserCardsRepository
{

    public function currentByUser(User $user):Collection
    {
        return UserCards::select(['users.*', 'user_cards.*'])
            ->join('users', 'user_cards.user_id', '=', 'users.id')
            ->where('user_cards.user_id', $user->id)
            ->get();
    }

    public function create(User $user, $cardId)
    {
        $userCard = new UserCards();
        $userCard->user()->associate($user);
        $userCard->card_id = $cardId;
        $userCard->save();

        return $userCard;
    }

}
