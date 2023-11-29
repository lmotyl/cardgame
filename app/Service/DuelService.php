<?php

namespace App\Service;

use App\Dtos\CardDto;
use App\Dtos\DuelDto;
use App\Models\Duel;
use App\Models\DuelPlayer;
use App\Models\User;
use App\Models\UserType;
use App\Repositories\DuelPlayerRepository;
use App\Repositories\DuelRepository;
use App\Repositories\DuelRoundRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DuelService
{
    public function __construct(
        private DuelRepository       $duelRepository,
        private DuelPlayerService    $duelPlayerService,
        private UserCardsService     $userCardsService,
        private LevelService         $levelService,
        private DuelCardsService     $duelCardsService,
        private DuelUsedCardsService $duelUsedCardsService,
        private UserScoreService     $userScoreService,
        private DuelRoundRepository  $duelRoundRepository
    ) {

    }
    protected function updateDuel(Duel $duel)
    {
        $rounds = config('game.params.rounds');
        $status = $duel->round+1 < $rounds ? Duel::STATUS_ACTIVE : Duel::STATUS_FINISHED;
        $this->duelRepository->update($duel,  $duel->round+1, $status);
    }

    protected function calculateScoreForDuelPlayer(Duel $duel, DuelPlayer $duelPlayer)
    {
//        $duelRounds = $this->duelRoundRepository->get($duel);
        return $duelPlayer->user_points;

//            $duelRounds->reduce(function($score, $item) use ($duelPlayer) {
//            if ($item->duel_player_id == $duelPlayer->id) {
//                return $score + $item->score;
//            }
//            return $score;
//        }, 0);
    }

    protected function actionForDuelPlayer(Duel $duel, DuelPlayer $duelPlayer, CardDto $card)
    {
        $this->duelUsedCardsService->create($duel, $duelPlayer, $card->id);
        $this->duelCardsService->pick($duel, $duelPlayer, $card->id);
        $this->duelRoundRepository->create($duel, $duelPlayer, $card);
    }


    public function prepareUserCards(User $user)
    {
        if (!$this->userCardsService->isNewCardAllowed($user)) {
            return $this->userCardsService->getCurrentCards($user);
        }

        $currentLevel = $this->levelService->currentLevel($user);
        $this->userCardsService->pickCardsByLevelDto($user, $currentLevel);
        return $this->userCardsService->getCurrentCards($user);
    }

    public function prepareDuelAvailableCards(Duel $duel, DuelPlayer $duelPlayer, Collection $cards)
    {
        $this->duelCardsService->setAvailableCards($duel, $duelPlayer, $cards);
    }

    public function getAvailableCards(Duel $duel, User $user)
    {
        $duelPlayer = $this->duelPlayerService->getByUser($duel, $user);

        return $this->duelCardsService->getAvailableCards($duel, $duelPlayer);
    }


    public function create(User $user, User $opponent)
    {
        $duel = $this->duelRepository->create();
        $userCards = $this->userCardsService->getCurrentCards($user);
        $opponenCards = $this->prepareUserCards($opponent);

        $userDuelPlayer = $this->duelPlayerService->create($duel, $user);
        $opponentDuelPlayer = $this->duelPlayerService->create($duel, $opponent);

        $this->prepareDuelAvailableCards($duel, $userDuelPlayer, $userCards);
        $this->prepareDuelAvailableCards($duel, $opponentDuelPlayer, $opponenCards);
    }

    public function current(User $user): ?Duel
    {
        return $this->duelRepository->currentByUser($user);
    }

    public function action(Duel $duel, User $user, CardDto $card)
    {
        $duelPlayer = $this->duelPlayerService->getByUser($duel, $user);
        $this->actionForDuelPlayer($duel, $duelPlayer, $card);

        $duelOpponent = $this->duelPlayerService->getOpponentByUser($duel, $user);
        $opponentCard = $this->duelCardsService->getRandom($duel, $duelOpponent);

        $this->actionForDuelPlayer($duel, $duelOpponent, $opponentCard);

        if ($card->power > $opponentCard->power) {
            $this->duelPlayerService->addPoints($duelPlayer, 1);
        } else {
            $this->duelPlayerService->addPoints($duelOpponent, 1);
        }

        $this->updateDuel($duel);
    }

    public function getScore(Duel $duel, User $user)
    {
        $duelPlayer = $this->duelPlayerService->getByUser($duel, $user);
        return $this->calculateScoreForDuelPlayer($duel, $duelPlayer);
    }

    public function getOpponentScore(Duel $duel, User $user)
    {
        $duelPlayer = $this->duelPlayerService->getOpponentByUser($duel, $user);
        return $this->calculateScoreForDuelPlayer($duel, $duelPlayer);
    }

    public function checkStatus(Duel $duel)
    {
        $rounds = config('game.params.rounds');

        return $duel->round < $rounds ? Duel::STATUS_ACTIVE : Duel::STATUS_FINISHED;
    }

    public function getWinner(Duel $duel)
    {
        $duelPlayers = $this->duelPlayerService->get($duel);
        $winner = $duelPlayers[0];
        foreach ($duelPlayers as $duelPlayer) {
            $winner = $duelPlayer->user_points >= $winner->user_points ? $duelPlayer : $winner;
        }

        return $winner;
    }

    public function close(Duel $duel)
    {
        $duelWinner = $this->getWinner($duel);
        $this->userScoreService->promoteWinner($duelWinner->user()->first());
    }

    public function get(User $user)
    {
        $duels = $this->duelRepository->getFinished();
        return $duels->map(function($duel) use ($user) {
            $player = $this->duelPlayerService->getByUser($duel, $user);
            $opponent = $this->duelPlayerService->getOpponentByUser($duel, $user);
            $opponentUser = $opponent->user()->first();
            $won = $player->user_points > $opponent->user_points;

            $duelDto = new DuelDto();
            $duelDto->playerName = $user->name;
            $duelDto->opponentName = $opponentUser->name;
            $duelDto->won = (int) $won;
            return $duelDto;
        });
    }
}
