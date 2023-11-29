<?php

namespace App\Repositories;

use App\Dtos\CardDto;
use Illuminate\Support\Collection;

class CardsRepository
{
    private Collection $cards;
    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        $cards = config('game.cards');
        $cardDtos = array_map(function($item) {
            $cardDto = new CardDto();
            $cardDto->id = $item['id'];
            $cardDto->name = $item['name'];
            $cardDto->power = $item['power'];
            $cardDto->image = $item['image'];
            return $cardDto;
        }, $cards);

        $this->cards = collect($cardDtos);
    }

    public function findRandom()
    {
        return $this->cards->random(1)->first();
    }

    public function find(int $id): ?CardDto
    {
        foreach($this->cards as $card) {
            if ($card->id == $id) {
                return $card;
            }
        }
        return null;
    }

    public function get()
    {
        return $this->cards;
    }
}
