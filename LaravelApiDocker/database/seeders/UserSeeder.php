<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Seed the "users" table with dummy data
        User::factory(26)->create();
    }
}
