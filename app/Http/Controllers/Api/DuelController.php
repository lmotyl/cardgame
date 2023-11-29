<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DuelActionRequest;
use App\Models\Duel;
use App\Models\User;
use App\Models\UserType;
use App\Service\CardsService;
use App\Service\DuelService;
use App\Service\LevelService;
use App\Service\UserService;

class DuelController extends Controller
{
    public function __construct(
        private DuelService $duelService,
        private UserService $userService,
        private CardsService $cardsService,
        private LevelService $levelService
    ) {

    }

    public function index()
    {
        $user = auth()->user();
        $duelDtos = $this->duelService->get($user);

        return response()->json($duelDtos->map(function($item) {
            return [
                'player_name' => $item->playerName,
                'opponent_name' => $item->opponentName,
                'won' => $item->won
            ];
        }));

    }

    public function create()
    {
        $user = auth()->user();
        $duel = $this->duelService->current($user);

        if (!$duel) {
            $userScore = $user->userScore()->first();
            $userLevel = $this->levelService->getLevelByScore($userScore);
            $opponent = $this->userService->getRandomByType(UserType::TYPE_CPU, $userLevel);
            if (!$opponent) {
                $this->userService->createRandomOpponent($userLevel);
                $opponent = $this->userService->getRandomByType(UserType::TYPE_CPU, $userLevel);
            }

            $this->duelService->create($user, $opponent);
        }

        return response()->json([]);
    }

    public function action(DuelActionRequest $duelActionRequest)
    {
        /** @var User $user */
        $user = auth()->user();
        $data = $duelActionRequest->toArray();
        $duel = $this->duelService->current($user);
        $card = $this->cardsService->getById((int)$data['id']);
        $statuses = config('game.statuses');

        if (!$duel) {
            return response()->json([], 404);
        }

        $this->duelService->action($duel, $user, $card);


        $playerScore = $this->duelService->getScore($duel, $user);
        $opponentScore = $this->duelService->getOpponentScore($duel, $user);
        $availableCards = $this->duelService->getAvailableCards($duel, $user);
        $status = $this->duelService->checkStatus($duel);

        if ($status == Duel::STATUS_FINISHED) {
            $this->duelService->close($duel);
        }

        return response()->json([
            'round' => $duel->round,
            'your_points' => $playerScore,
            'opponent_points' => $opponentScore,
            'cards' => $availableCards,
            'status' => $statuses[$duel->status]
        ]);
    }

    public function active()
    {
        /** @var User $user */
        $user = auth()->user();
        $statuses = config('game.statuses');

        $duel = $this->duelService->current($user);
        $playerScore = $this->duelService->getScore($duel, $user);
        $opponentScore = $this->duelService->getOpponentScore($duel, $user);
        $availableCards = $this->duelService->getAvailableCards($duel, $user);

        return response()->json([
            'round' => $duel->round,
            'your_points' => $playerScore,
            'opponent_points' => $opponentScore,
            'cards' => $availableCards,
            'status' => $statuses[$duel->status]
        ]);
    }
}
