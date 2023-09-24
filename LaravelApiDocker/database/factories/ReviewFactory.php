<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{

    public function definition()
    {
        return [
            'user_id' => User::all()->random()->id,
            'game_id' => Game::all()->random()->id,
            'content' => $this->faker->paragraph()
        ];
    }
}
