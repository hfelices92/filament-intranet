<?php

namespace Database\Seeders;

use App\Models\Calendar;
use App\Models\Holiday;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create();

        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        for ($i = 0; $i < 3; $i++) {
            Calendar::create([
                'name' => $faker->word(),
                'year' => $faker->year(),
            ]);
        }

        for ($i = 0; $i < 5; $i++) {
            Holiday::create([
                'calendar_id' => Calendar::inRandomOrder()->value('id'),
                'user_id'     => User::inRandomOrder()->value('id'),
                'day'         => $faker->date(),
                'type'        => $faker->randomElement(['declined', 'accepted', 'pending']),
            ]);
        }
    }
}
