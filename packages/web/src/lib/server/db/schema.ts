import { pgTable, serial, text, integer } from 'drizzle-orm/pg-core';

export const games = pgTable('games', {
	id: serial('id').primaryKey(),
	name: text('name')
});

export const gameModes = pgTable('game_modes', {
	id: serial('id').primaryKey(),
	name: text('name')
});

export const organisations = pgTable('organisations', {
	id: serial('id').primaryKey(),
	name: text('name')
});

export const organistaionMembers = pgTable('organisation_members', {
	id: serial('id').primaryKey()
});

export const events = pgTable('events', {
	id: serial('id').primaryKey(),
	name: text('name')
});

export const eventGroups = pgTable('event_groups', {
	id: serial('id').primaryKey(),
	name: text('name')
});

export const rounds = pgTable('rounds', {
	id: serial('id').primaryKey()
});

export const osuMaps = pgTable('osu_maps', {
	id: serial('id').primaryKey(),
	beatmapId: integer('beatmap_id')
});

export const osuMapSets = pgTable('osu_map_sets', {
	id: serial('id').primaryKey(),
	name: text('name')
});

export const osuMapPools = pgTable('osu_map_pools', {
	id: serial('id').primaryKey(),
	name: text('name')
});

export const osuMessages = pgTable('osu_messages', {
	id: serial('id').primaryKey()
});

export const mods = pgTable('mods', {
	id: serial('id').primaryKey(),
	name: text('name')
});

export const platforms = pgTable('platforms', {
	id: serial('id').primaryKey(),
	name: text('name')
});

export const predictions = pgTable('predictions', {
	id: serial('id').primaryKey()
});

export const ratings = pgTable('ratings', {
	id: serial('id').primaryKey()
});

export const matches = pgTable('matches', {
	id: serial('id').primaryKey()
});

export const matchParticipants = pgTable('match_participants', {
	id: serial('id').primaryKey()
});

export const matchParticipantPlayers = pgTable('match_participant_players', {
	id: serial('id').primaryKey()
});

export const matchRolls = pgTable('match_rolls', {
	id: serial('id').primaryKey()
});

export const matchBans = pgTable('match_bans', {
	id: serial('id').primaryKey()
});

export const matchPicks = pgTable('match_maps', {
	id: serial('id').primaryKey()
});

export const scores = pgTable('scores', {
	id: serial('id').primaryKey()
});

export const teams = pgTable('teams', {
	id: serial('id').primaryKey(),
	name: text('name')
});

export const teamMembers = pgTable('team_members', {
	id: serial('id').primaryKey()
});

export const users = pgTable('users', {
	id: serial('id').primaryKey(),
	username: text('username'),
	email: text('email')
});

export const badges = pgTable('badges', {
	id: serial('id').primaryKey(),
	name: text('name')
});
