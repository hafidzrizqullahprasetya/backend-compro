<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 1; $i <= 5; $i++) {
            Admin::create([
                'username' => fake()->userName(),
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('password'),
            ]);
        }
    }
}
