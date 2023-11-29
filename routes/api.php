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

Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    //START THE DUEL
    Route::post('duels', [\App\Http\Controllers\Api\DuelController::class, 'create'])->name('duels.create');

    //CURRENT GAME DATA
    Route::get('duels/active', [\App\Http\Controllers\Api\DuelController::class, 'active'])->name('duels.active');

    //User has just selected a card
    Route::post('duels/action', [\App\Http\Controllers\Api\DuelController::class, 'action'])->name('duels.action');

    //DUELS HISTORY
    Route::get('duels',  [\App\Http\Controllers\Api\DuelController::class, 'index'])->name('duels.index');

    //CARDS
    Route::post('cards', [\App\Http\Controllers\Api\CardController::class, 'card'])->name('cards');

    //USER DATA
    Route::get('user-data', [\App\Http\Controllers\Api\UserController::class, 'data'])->name('user.data');
});
