<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        factory(\App\Models\User::class, 5)->create();
//        factory(\App\Models\Poll::class, 10)->create();
//        factory(\App\Models\Question::class, 50)->create();
//        factory(\App\Models\Answer::class, 500)->create();
        \App\Models\User::factory(5)->create();
        \App\Models\Poll::factory(10)->create();
        \App\Models\Question::factory(50)->create();
        \App\Models\Answer::factory(500)->create();
        // \App\Models\User::factory(10)->create();
    }
}
