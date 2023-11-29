<?php

namespace App\Dtos;

use Illuminate\Support\Collection;

class UserDataDto
{
    public $id;
    public $username;
    public $level;
    public $score;

    public array|Collection $cards;

    public bool $newCardAllowed = false;
}
