import { relations } from "drizzle-orm";
import {
  pgTable,
  serial,
  text,
  integer,
  real,
  boolean,
  uuid,
} from "drizzle-orm/pg-core";

export const games = pgTable("games", {
  id: serial("id").primaryKey(),
  name: text("name"),
});

export const gameModes = pgTable("game_modes", {
  id: serial("id").primaryKey(),
  name: text("name"),
});

export const organisations = pgTable("organisations", {
  id: serial("id").primaryKey(),
  name: text("name"),
});

export const organistaionMembers = pgTable("organisation_members", {
  id: serial("id").primaryKey(),
});

export const events = pgTable("events", {
  id: serial("id").primaryKey(),
  name: text("name"),
});

export const eventGroups = pgTable("event_groups", {
  id: serial("id").primaryKey(),
  name: text("name"),
});

export const rounds = pgTable("rounds", {
  id: serial("id").primaryKey(),
});

export const osuMaps = pgTable("osu_maps", {
  id: serial("id").primaryKey(),
  beatmapId: integer("beatmap_id"),
  difficultyName: text("difficulty_name"),
  stars: real("stars"),
});

export const osuMapsRelations = relations(osuMaps, ({ many, one }) => ({
  osuMapPoolMaps: many(osuMapPoolMaps),
  osuMapSet: one(osuMapSets),
}));

export const osuMapSets = pgTable("osu_map_sets", {
  id: serial("id").primaryKey(),
  name: text("name"),
  artist: text("artist"),
  title: text("title"),
});

export const osuMapSetsRelations = relations(osuMaps, ({ many }) => ({
  osuMap: many(osuMaps),
}));

export const osuMapPools = pgTable("osu_map_pools", {
  id: serial("id").primaryKey(),
  name: text("name"),
});

export const osuMapPoolsRelations = relations(osuMapPools, ({ many }) => ({
  maps: many(osuMapPoolMaps),
  matches: many(matches),
}));

export const osuMapPoolMaps = pgTable("osu_map_pool_maps", {
  id: serial("id").primaryKey(),
  osuMapId: integer("osu_map_id")
    .notNull()
    .references(() => osuMaps.id),
  osuMapPoolId: integer("osu_map_pool_id")
    .notNull()
    .references(() => osuMapPools.id),
});

export const osuMapPoolMapsRelations = relations(osuMapPoolMaps, ({ one }) => ({
  osuMapPool: one(osuMapPools, {
    fields: [osuMapPoolMaps.osuMapPoolId],
    references: [osuMapPools.id],
  }),
  osuMap: one(osuMaps, {
    fields: [osuMapPoolMaps.osuMapId],
    references: [osuMaps.id],
  }),
}));

export const osuMessages = pgTable("osu_messages", {
  id: serial("id").primaryKey(),
  username: text("username"),
  channel: text("channel"),
  message: text("message"),
});

export const mods = pgTable("mods", {
  id: serial("id").primaryKey(),
  name: text("name"),
});

export const platforms = pgTable("platforms", {
  id: serial("id").primaryKey(),
  name: text("name"),
});

export const predictions = pgTable("predictions", {
  id: serial("id").primaryKey(),
});

export const ratings = pgTable("ratings", {
  id: serial("id").primaryKey(),
});

export const matches = pgTable("matches", {
  id: serial("id").primaryKey(),
  mapPoolId: integer("map_pool_id").references(() => osuMapPools.id),
  isRolling: boolean("is_rolling"),
  currentBanner: integer("current_banner_id").references(
    () => matchParticipants.id
  ),
  bansPerMatchParticipant: integer("bans_per_match_participant"),
  currentPicker: integer("current_picker_id").references(
    () => matchParticipants.id
  ),
});

export const matchRelations = relations(matches, ({ one, many }) => ({
  game: one(games),
  gameMode: one(gameModes),
  event: one(events),
  round: one(rounds),
  participants: many(matchParticipants),
  currentBanner: one(matchParticipants, {
    fields: [matches.currentBanner],
    references: [matchParticipants.id],
  }),
  currentPicker: one(matchParticipants, {
    fields: [matches.currentPicker],
    references: [matchParticipants.id],
  }),
  mapPool: one(osuMapPools, {
    fields: [matches.mapPoolId],
    references: [osuMapPools.id],
  }),
  rolls: many(matchRolls),
  bans: many(matchBans),
  picks: many(matchPicks),
}));

export const matchParticipants = pgTable("match_participants", {
  id: serial("id").primaryKey(),
  matchId: integer("match_id").references(() => matches.id),
});

export const matchParticipantsRelations = relations(
  matchParticipants,
  ({ one, many }) => ({
    match: one(matches, {
      fields: [matchParticipants.matchId],
      references: [matches.id],
    }),
    players: many(matchParticipantPlayers),
  })
);

export const matchParticipantPlayers = pgTable("match_participant_players", {
  id: serial("id").primaryKey(),
  matchParticipantId: integer("match_participant_id").references(
    () => matchParticipants.id
  ),
  teamMemberId: integer("team_member_id").references(() => teamMembers.id),
});

export const matchParticipantPlayersRelations = relations(
  matchParticipantPlayers,
  ({ one }) => ({
    matchParticipant: one(matchParticipants, {
      fields: [matchParticipantPlayers.matchParticipantId],
      references: [matchParticipants.id],
    }),
    teamMember: one(teamMembers),
  })
);

export const matchRolls = pgTable("match_rolls", {
  id: serial("id").primaryKey(),
  matchId: integer("match_id").references(() => matches.id),
  matchParticipantId: integer("match_participant_id").references(
    () => matchParticipants.id
  ),
  roll: integer("roll"),
});

export const matchRollsRelations = relations(matchRolls, ({ one }) => ({
  matchId: one(matches, {
    fields: [matchRolls.matchId],
    references: [matches.id],
  }),
  matchParticipant: one(matchParticipants, {
    fields: [matchRolls.matchParticipantId],
    references: [matchParticipants.id],
  }),
}));

export const matchBans = pgTable("match_bans", {
  id: serial("id").primaryKey(),
  matchId: integer("match_id").references(() => matches.id),
  matchParticipantId: integer("match_participant_id").references(
    () => matchParticipants.id
  ),
  mapPoolMapId: integer("map_pool_map_id").references(() => osuMapPoolMaps.id),
});

export const matchBansRelations = relations(matchBans, ({ one }) => ({
  matchId: one(matches, {
    fields: [matchBans.matchId],
    references: [matches.id],
  }),
  matchParticipant: one(matchParticipants, {
    fields: [matchBans.matchParticipantId],
    references: [matchParticipants.id],
  }),
  mapPoolMap: one(osuMapPoolMaps, {
    fields: [matchBans.mapPoolMapId],
    references: [osuMapPoolMaps.id],
  }),
}));

export const matchPicks = pgTable("match_picks", {
  id: serial("id").primaryKey(),
  matchId: integer("match_id").references(() => matches.id),
  mapPoolMapId: integer("map_pool_map_id").references(() => osuMapPoolMaps.id),
});

export const matchPicksRelations = relations(matchPicks, ({ one }) => ({
  matchId: one(matches, {
    fields: [matchPicks.matchId],
    references: [matches.id],
  }),
  mapPoolMap: one(osuMapPoolMaps, {
    fields: [matchPicks.mapPoolMapId],
    references: [osuMapPoolMaps.id],
  }),
}));

export const scores = pgTable("scores", {
  id: serial("id").primaryKey(),
});

export const teams = pgTable("teams", {
  id: serial("id").primaryKey(),
  name: text("name"),
});

export const teamRelations = relations(teams, ({ many }) => ({
  teamMembers: many(teamMembers),
}));

export const teamMembers = pgTable("team_members", {
  id: serial("id").primaryKey(),
  teamId: integer("team_id").references(() => teams.id),
  userId: uuid("user_id").references(() => users.id),
});

export const teamMembersRelations = relations(teamMembers, ({ one }) => ({
  team: one(teams),
  user: one(users),
}));

export const users = pgTable("users", {
  id: uuid("id").primaryKey(),
  username: text("username"),
  displayName: text("display_name"),
  email: text("email"),
  profile_picture: text("profile_picture"),
});

export const userRelations = relations(users, ({ many }) => ({
  teamMembers: many(teamMembers),
}));

export const badges = pgTable("badges", {
  id: serial("id").primaryKey(),
  name: text("name"),
});
