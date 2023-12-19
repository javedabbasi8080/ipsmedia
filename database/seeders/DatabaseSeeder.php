<?php

namespace Database\Seeders;

use App\Models\Lesson;
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
        $lessons = Lesson::factory()
            ->count(50)
            ->create();

            User::factory()
            ->count(1)
            ->create();


            $this->call([
                AchievementSeeder::class,
                BadgesSeeder::class
            ]);
    }
}
