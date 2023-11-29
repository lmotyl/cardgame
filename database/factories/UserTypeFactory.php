<?php

namespace Database\Factories;

use App\Models\UserType;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserTypeFactory extends Factory
{
    public function definition()
    {
        return [
            'type' => fake()->randomElements([UserType::TYPE_HUMAN, UserType::TYPE_CPU])
        ];
    }


}
