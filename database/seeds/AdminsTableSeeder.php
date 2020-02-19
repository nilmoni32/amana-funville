<?php

use App\Models\Admin;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        // creating database seeds for admin table.
        Admin::create([

        'name' => $faker->name,
        'email' => 'mustafi.amana@gmail.com',       
        'password' => bcrypt('password'),        

        ]);
    }
}
