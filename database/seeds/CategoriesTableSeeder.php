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
            [
                'id' => 1,
                'name' => "BEST PICTURE"
            ],
            [
                'id' => 2,
                'name' => "ACTOR IN A LEADING ROLE"
            ],
            [
                'id' => 3,
                'name' => "ACTRESS IN A LEADING ROLE"
            ],
            [
                'id' => 4,
                'name' => "ACTOR IN A SUPPORTING ROLE"
            ],
            [
                'id' => 5,
                'name' => "ACTRESS IN A SUPPORTING ROLE"
            ],
            [
                'id' => 6,
                'name' => "ANIMATED FEATURE FILM"
            ],
            [
                'id' => 7,
                'name' => "CINEMATOGRAPHY"
            ],
            [
                'id' => 8,
                'name' => "COSTUME DESIGN"
            ],
            [
                'id' => 9,
                'name' => "DIRECTING"
            ],
            [
                'id' => 10,
                'name' => "DOCUMENTARY (FEATURE)"
            ],
            [
                'id' => 11,
                'name' => "DOCUMENTARY (SHORT SUBJECT)"
            ],
            [
                'id' => 12,
                'name' => "FILM EDITING"
            ],
            [
                'id' => 13,
                'name' => "FOREIGN LANGUAGE FILM"
            ],
            [
                'id' => 14,
                'name' => "MAKEUP AND HAIRSTYLING"
            ],
            [
                'id' => 15,
                'name' => "MUSIC (ORIGINAL SCORE)"
            ],
            [
                'id' => 16,
                'name' => "MUSIC (ORIGINAL SONG)"
            ],
            [
                'id' => 17,
                'name' => "PRODUCTION DESIGN"
            ],
            [
                'id' => 18,
                'name' => "SHORT FILM (ANIMATED)"
            ],
            [
                'id' => 19,
                'name' => "SHORT FILM (LIVE ACTION)"
            ],
            [
                'id' => 20,
                'name' => "SOUND EDITING"
            ],
            [
                'id' => 21,
                'name' => "SOUND MIXING"
            ],
            [
                'id' => 22,
                'name' => "VISUAL EFFECTS"
            ],
            [
                'id' => 23,
                'name' => "WRITING (ADAPTED SCREENPLAY)"
            ],
            [
                'id' => 24,
                'name' => "WRITING (ORIGINAL SCREENPLAY)"
            ]
        ]);
    }
}
