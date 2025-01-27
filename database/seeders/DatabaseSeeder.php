<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            "name" => "ilghar",
            "email" => "ilghar@gmail.com",
            "phone" => "09033149956",
            "password" => "IRE.09.88",
            "role" => 0,
        ]);
    }
}
