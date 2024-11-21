<?php

use App\Models\Map;
use App\Models\MapPool;
use App\Models\MapSet;
use App\Models\EventGroup;
use App\Models\Game;
use App\Models\GameMode;
use App\Models\Organisation;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('game_modes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('event_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(Organisation::class);
            $table->timestamps();
        });

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('has_qualifier_stage')->default(true);
            $table->boolean('has_group_stage')->default(false);
            $table->foreignIdFor(EventGroup::class)->nullable();
            $table->foreignIdFor(Organisation::class);
            $table->timestamps();
        });

        Schema::create('organisations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('organisation_members', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Organisation::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
            $table->timestamps();
        });

        Schema::create('event_game_mode', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained();
            $table->foreignId('game_mode_id')->constrained();
            $table->timestamps();
        });

        Schema::create('rounds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained();
            $table->timestamps();
        });

        Schema::create('event_team', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained();
            $table->foreignId('team_id')->constrained();
            $table->timestamps();
        });

        Schema::create('map_pools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('map_sets', function (Blueprint $table) {
            $table->id();
            $table->string('artist');
            $table->string('title');
            $table->integer('osu_id');
            $table->timestamps();
        });

        Schema::create('maps', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(MapSet::class)->constrained();
            $table->string('difficulty_name');
            $table->integer('osu_id');
            $table->timestamps();
        });

        Schema::create('map_pool_maps', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(MapPool::class);
            $table->foreignIdFor(Map::class)->nullable();
            $table->timestamps();
        });

        Schema::create('vash_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(MapPool::class);
            $table->timestamps();
        });

        Schema::create('mods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
