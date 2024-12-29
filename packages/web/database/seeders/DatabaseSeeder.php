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

        DB::table('games')->insert([[
            'name' => 'osu!',
        ], [
            'name' => 'osu!taiko',
        ], [
            'name' => 'osu!catch',
        ], [
            'name' => 'osu!mania',
        ]]);

        DB::table('game_modes')->insert([[
            'name' => 'osu!standard',
            'game_id' => 1,
        ], [
            'name' => 'osu!taiko',
            'game_id' => 2,
        ], [
            'name' => 'osu!catch',
            'game_id' => 3,
        ], [
            'name' => 'osu!mania',
            'game_id' => 4,
        ]]);

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

        DB::table('map_pools')->insert([
            'name' => 'Test Map Pool',
            'rating' => 1000,
            'verified_at' => now(),
        ]);

        DB::table('map_pool_maps')->insert([[
            'map_pool_id' => 1,
            'map_id' => 1,
        ], [
            'map_pool_id' => 1,
            'map_id' => 2,

        ], [
            'map_pool_id' => 1,
            'map_id' => 3,

        ], [
            'map_pool_id' => 1,
            'map_id' => 1,

        ], [
            'map_pool_id' => 1,
            'map_id' => 1,

        ], [
            'map_pool_id' => 1,
            'map_id' => 1,

        ], [
            'map_pool_id' => 1,
            'map_id' => 1,

        ]]);

        User::factory()->create([
            'email' => 'test@example.com',
        ]);

        DB::table('profiles')->insert([[
            'user_id' => 1,
            'username' => 'stanrunge',
            'display_name' => 'Stan',
        ]]);

        DB::table('platforms')->insert([[
            'name' => 'osu!',
        ]]);

        DB::table('platform_profile')->insert([[
            'profile_id' => 1,
            'platform_id' => 1,
            'id' => 11212255,
            'name' => 'Stan',
        ]]);

        DB::table('organisations')->insert([[
            'name' => 'Test Organisation',
        ]]);

        DB::table('organisation_members')->insert([[
            'organisation_id' => 1,
            'profile_id' => 1,
        ]]);

        DB::table('event_groups')->insert([[
            'organisation_id' => 1,
            'name' => 'Test Event Group',
        ]]);

        DB::table('teams')->insert([[
            'name' => 'Test Team',
            'is_personal_team' => true,
        ]]);

        DB::table('team_members')->insert([[
            'team_id' => 1,
            'profile_id' => 1,
        ]]);

        DB::table('ratings')->insert([[
            'team_id' => 1,
            'game_id' => 1,
            'rating' => 1000,
        ]]);

        User::factory()->create([
            'email' => 'test2@example.com',
        ]);

        DB::table('profiles')->insert([[
            'user_id' => 2,
            'username' => 'stanrunge2',
            'display_name' => 'Stan 2',
        ]]);

        DB::table('organisations')->insert([[
            'name' => 'Test Organisation 2',
        ]]);

        DB::table('organisation_members')->insert([[
            'organisation_id' => 2,
            'profile_id' => 2,
        ]]);

        DB::table('event_groups')->insert([[
            'organisation_id' => 2,
            'name' => 'Test Event Group 2',
        ]]);

        DB::table('teams')->insert([[
            'name' => 'Test Team 2',
            'is_personal_team' => true,
        ]]);

        DB::table('team_members')->insert([[
            'team_id' => 2,
            'profile_id' => 2,
        ]]);

        DB::table('ratings')->insert([[
            'team_id' => 2,
            'game_id' => 1,
            'rating' => 1100,
        ]]);

    }
}
