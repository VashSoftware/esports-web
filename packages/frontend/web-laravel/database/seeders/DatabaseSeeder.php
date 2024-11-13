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

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
