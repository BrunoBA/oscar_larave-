<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        // $this->call([
        //     // UsersTableSeeder::class,
        //     CategoriesTableSeeder::class,
        //     FeaturesTableSeeder::class,
        //     CategoriesFeaturesTableSeeder::class,
        // ]);2
        $faker = Faker::create();
    	foreach (range(1,1000) as $index) {
            // DB::table('users')->insert([
            //     'name' => $faker->name,
            //     'email' => $faker->email,
            //     'password' => '$2y$10$KVtGj.pcxfb9LULEfl.V5e9thw7uD/EltKyF.YLM5I.62p12AW.M6'
            // ]);
        }
 
    }
}
