<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserScore;
use App\Models\UserType;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->has(UserType::factory()->state(['type' => UserType::TYPE_HUMAN]))
            ->has(UserScore::factory())
            ->create();
        User::factory()
            ->has(UserType::factory()->state(['type' => UserType::TYPE_CPU]))
            ->has(UserScore::factory())
            ->count(5)
            ->create();
    }
}
