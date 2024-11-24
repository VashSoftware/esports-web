<?php

use App\Models\GameMode;
use App\Models\Map;
use App\Models\MapPool;
use App\Models\MapSet;
use App\Models\EventGroup;
use App\Models\Event;
use App\Models\Game;
use App\Models\MatchParticipant;
use App\Models\Profile;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\VashMatch;
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

        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('profile_picture');
            $table->timestamps();
        });

        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Profile::class);
            $table->foreignIdFor(Game::class);
            $table->integer('rating');
            $table->timestamps();
        });

        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('picture');
            $table->string('name');
            $table->foreignIdFor(Profile::class);
            $table->timestamps();
        });

        Schema::create('game_modes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Game::class)->constrained();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained();
            $table->foreignId('profile_id')->constrained();
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
            $table->foreignIdFor(Profile::class)->constrained();
            $table->timestamps();
        });

        Schema::create('event_game_mode', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Event::class)->constrained();
            $table->foreignIdFor(GameMode::class)->constrained();
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

        Schema::create('match_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(VashMatch::class);
            $table->foreignIdFor(Team::class);
            $table->timestamps();
        });

        Schema::create('match_participant_players', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(MatchParticipant::class);
            $table->foreignIdFor(TeamMember::class);
            $table->timestamps();
        });

        Schema::create('mods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->timestamps();
        });

        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vash_match_id')->constrained();
            $table->integer('score');
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
