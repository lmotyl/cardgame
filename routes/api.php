<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Authorization\LoginController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    //START THE DUEL
    Route::post('duels', [\App\Http\Controllers\Api\DuelController::class, 'create']

//        function (Request $request) {
//       return response()->json();
//    }
    );

    //CURRENT GAME DATA
    Route::get('duels/active', [\App\Http\Controllers\Api\DuelController::class, 'active']

//        function (Request $request) {
//        return [
//            'round' => 4,
//            'your_points' => 260,
//            'opponent_points' => 100,
//            'status' => 'active',
//            'cards' => config('game.cards'),
//        ];
//    }
    );

    //User has just selected a card
    Route::post('duels/action', [\App\Http\Controllers\Api\DuelController::class, 'action']
//        function (Request $request) {
//            return response()->json();
//        }
    );

    //DUELS HISTORY
    Route::get('duels',  [\App\Http\Controllers\Api\DuelController::class, 'index']
//        function (Request $request) {
//        return [
//            [
//                "id" => 1,
//                "player_name" => "Jan Kowalski",
//                "opponent_name" => "Piotr Nowak",
//                "won" => 0
//            ],
//            [
//                "id" => 2,
//                "player_name" => "Jan Kowalski",
//                "opponent_name" => "Tomasz Kaczyński",
//                "won" => 1
//            ],
//            [
//                "id" => 3,
//                "player_name" => "Jan Kowalski",
//                "opponent_name" => "Agnieszka Tomczak",
//                "won" => 1
//            ],
//            [
//                "id" => 4,
//                "player_name" => "Jan Kowalski",
//                "opponent_name" => "Michał Bladowski",
//                "won" => 1
//            ],
//        ];
//    }
    )
    ;

    //CARDS
    Route::post('cards', [\App\Http\Controllers\Api\CardController::class, 'card']);

    //USER DATA
    Route::get('user-data', [\App\Http\Controllers\Api\UserController::class, 'data']

//        function (Request $request) {
//        return [
//            'id' => 1,
//            'username' => 'Test User',
//            'level' => 1,
//            'level_points' => '40/100',
//            'cards' => config('game.cards'),
//            'new_card_allowed' => true,
//        ];
//    }
    );
});
