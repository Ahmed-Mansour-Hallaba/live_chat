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
         \App\Models\User::factory(1)->create([
             'email'=>'mans@123',
             'password'=>bcrypt('123')
         ]);
         \App\Models\User::factory(1)->create([
             'email'=>'ahmed@123',
             'password'=>bcrypt('123')
         ]);
    }
}
