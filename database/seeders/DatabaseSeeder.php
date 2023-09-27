<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         \App\Models\User::factory()->create([
             'name' => 'Test User',
             'email' => 'test@example.com',
             'password' => bcrypt(12345678)
         ]);

        \App\Models\UserPhone::factory()->create([
            'user_id' => 1,
            'phone_number' => '48991890827'
        ]);

        \App\Models\User::factory(20)->create();

        for ($i = 2; $i <= 21; $i++) {
            \App\Models\UserPhone::factory(rand(1,3))->create([
                'user_id' => $i,
                'phone_number' => fake()->unique()->numerify('###########'),
            ]);
        }
    }
}
