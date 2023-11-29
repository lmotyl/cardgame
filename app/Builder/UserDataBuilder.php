<?php

namespace App\Builder;

use App\Dtos\UserDataDto;
use App\Models\User;
use App\Service\UserService;

class UserDataBuilder
{
    public function __construct(
        private User $user,
        private UserService $userService,

    ) {

    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function setCards()


    public function make()
    {
        $userDataDto = new UserDataDto();
        $this->userService->data($this->user, $userDataDto);

    }

}
