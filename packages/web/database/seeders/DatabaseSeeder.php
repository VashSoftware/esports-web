<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        DB::table('mods')->insert([
            'name' => 'No Mod',
            'code' => '',
        ]);

        DB::table('mods')->insert([
            'name' => 'Hidden',
            'code' => 'HD',
        ]);

        DB::table('mods')->insert([
            'name' => 'Hard Rock',
            'code' => 'HR',
        ]);

        DB::table('mods')->insert([
            'name' => 'Double Time',
            'code' => 'DT',
        ]);

        DB::table('mods')->insert([
            'name' => 'FreeMod',
            'code' => 'FM',
        ]);

        DB::table('mods')->insert([
            'name' => 'Tiebreaker',
            'code' => 'TB',
        ]);

        DB::table('map_sets')->insert([[
            'artist' => 'Test Artist',
            'title' => 'Test Title',
            'osu_id' => 12345,
        ], [
           'artist' => 'Test Artist 2',
           'title' => 'Test Title 2',
           'osu_id' => 12346,
        ], [
           'artist' => 'Test Artist 3',
           'title' => 'Test Title 3',
           'osu_id' => 12347,
            ]]);

        DB::table('maps')->insert([[
            'difficulty_name' => 'Test Difficulty',
            'osu_id' => 12345,
            'map_set_id' => 1,
        ], [
            'difficulty_name' => 'Test Difficulty 2',
            'osu_id' => 12346,
            'map_set_id' => 2,
        ], [
            'difficulty_name' => 'Test Difficulty 3',
            'osu_id' => 12347,
            'map_set_id' => 3,
        ]]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
