<?php

namespace App\Service;

use App\Repositories\CardsRepository;

class CardsService
{
    public function __construct(
        private CardsRepository $cardsRepository
    )
    {

    }

    public function get()
    {
        return $this->cardsRepository->get();
    }
    public function getRandom()
    {
        return $this->cardsRepository->findRandom();
    }

    public function getById(int $id)
    {
        return $this->cardsRepository->find($id);
    }

}
