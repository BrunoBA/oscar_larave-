<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['id' => 1, 'name' => "BEST MOTION PICTURE OF THE YEAR"],
            ['id' => 2, 'name' => "BEST PERFORMANCE BY AN ACTOR IN A LEADING ROLE"],
            ['id' => 3, 'name' => "BEST PERFORMANCE BY AN ACTRESS IN A LEADING ROLE"],
            ['id' => 4, 'name' => "BEST PERFORMANCE BY AN ACTOR IN A SUPPORTING ROLE"],
            ['id' => 5, 'name' => "BEST PERFORMANCE BY AN ACTRESS IN A SUPPORTING ROLE"],
            ['id' => 6, 'name' => "BEST ACHIEVEMENT IN DIRECTING"],
            ['id' => 7, 'name' => "BEST ORIGINAL SCREENPLAY"],
            ['id' => 8, 'name' => "BEST ADAPTED SCREENPLAY"],
            ['id' => 9, 'name' => "BEST ACHIEVEMENT IN CINEMATOGRAPHY"],
            ['id' => 10, 'name' => "BEST ACHIEVEMENT IN FILM EDITING"],
            ['id' => 11, 'name' => "BEST ACHIEVEMENT IN PRODUCTION DESIGN"],
            ['id' => 12, 'name' => "BEST ACHIEVEMENT IN COSTUME DESIGN"],
            ['id' => 13, 'name' => "BEST ACHIEVEMENT IN MAKEUP AND HAIRSTYLING"],
            ['id' => 14, 'name' => "BEST ACHIEVEMENT IN MUSIC WRITTEN FOR MOTION PICTURES (ORIGINAL SCORE)"],
            ['id' => 15, 'name' => "BEST ACHIEVEMENT IN MUSIC WRITTEN FOR MOTION PICTURES (ORIGINAL SONG)"],
            ['id' => 16, 'name' => "BEST ACHIEVEMENT IN SOUND MIXING"],
            ['id' => 17, 'name' => "BEST ACHIEVEMENT IN SOUND EDITING"],
            ['id' => 18, 'name' => "BEST ACHIEVEMENT IN VISUAL EFFECTS"],
            ['id' => 19, 'name' => "BEST DOCUMENTARY FEATURE"],
            ['id' => 20, 'name' => "BEST DOCUMENTARY SHORT SUBJECT"],
            ['id' => 21, 'name' => "BEST ANIMATED FEATURE FILM"],
            ['id' => 22, 'name' => "BEST ANIMATED SHORT FILM"],
            ['id' => 23, 'name' => "BEST LIVE ACTION SHORT FILM"],
            ['id' => 24, 'name' => "BEST FOREIGN LANGUAGE FILM OF THE YEAR"],
        ]);
    }
}
