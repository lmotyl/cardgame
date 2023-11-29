<?php

use App\Models\User;
use App\Models\UserScore;
use App\Models\UserType;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Hash;

uses(Tests\TestCase::class)->in('Feature');

function authorize(): User
{
    $faker = \Faker\Factory::create();

    $userData = [
        'name' => $faker->firstName.' '.$faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => Hash::make('password'),
    ];

    /** @var User $user */
    $user = User::factory()
        ->has(UserType::factory()->state(['type' => UserType::TYPE_HUMAN]))
        ->has(UserScore::factory())
        ->create($userData);

    Sanctum::$personalAccessTokenModel = PersonalAccessToken::class;
    Sanctum::actingAs(
        $user,
        ['*']
    );
    $loginResponse = test()->post(route('login'), [
        'email' => $userData['email'],
        'password' => 'password'
    ], ['accept' => 'application/json']);
    $token = PersonalAccessToken::findToken($loginResponse->json(['data', 'token']));
    $user->withAccessToken($token);

    return $user;
}
