<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BadgesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Badge::insert([

            ['name' => 'Beginner' , 'achievement_no' => 0],
            ['name' => 'Intermediate' , 'achievement_no' => 4],
            ['name' => 'Advanced' , 'achievement_no' => 8],
            ['name' => 'Master' , 'achievement_no' => 10]

        ]);
    }
}
