<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RatingFactory extends Factory
{

    public function definition()
    {
        return [
            'user_id' => User::all()->random()->id,
            'game_id' => Game::all()->random()->id,
            'rating' => $this->faker->numberBetween(1, 10)
        ];
    }
}
