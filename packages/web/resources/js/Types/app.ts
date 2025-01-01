export interface Team {
    id: number
    name: string
    team_members: TeamMember[]
    match_participants: MatchParticipant[]
}

export interface TeamMember {
    id: number
    team_id: number
    team: Team
    profile_id: number | null
    profile: Profile | null
}

export interface MatchParticipant {
    id: number
    match_id: number,
    match: Match
    team_id: number
    team: Team
    match_participant_players: MatchParticipantPlayer[]
}

export interface MatchParticipantPlayer {
    id: number
    match_participant_id: number
    match_participant: MatchParticipant
    team_member_id: number
    team_member: TeamMember
}

export interface MatchMap {
    id: number
    match_id: number
    match: Match
    map_pool_map_id: number
    map_pool_map: MapPoolMap
    scores: Score[]
}

export interface Map {
    id: number
    map_set: MapSet
    difficulty_name: string
}

export interface MapSet {
    id: number
    maps: Map[]
    artist: string
    title: string
}

export interface MapPool {
    id: number
    name: string
    map_pool_maps: MapPoolMap[]
}

export interface MapPoolMap {
    id: number
    map_pool_id: number
    map_pool: MapPool
    map_id: number
    map: Map | null
    map_pool_map_mods: MapPoolMapMod[]
}

export interface Mod {
    id: number
    name: string
    code: string
    map_pool_map_mods: MapPoolMapMod[]
}

export interface MapPoolMapMod {
    id: number
    map_pool_map_id: number
    map_pool_map: MapPoolMap
    mod_id: number
    mod: Mod
}

export interface Match {
    id: number
    map_pool_id: number
    map_pool: MapPool
    match_participants: MatchParticipant[]
    match_maps: MatchMap[],
    event_id: number | null,
    event: Event
    round_id: number | null,
    round: Round,
    finished_at: string | null,
    current_picker: number | null,
    current_banner: number | null,
    action_limit: string | null
}

export interface Score {
    id: number
    match_participant_player_id: number
    match_participant_player: MatchParticipantPlayer
    score: number
}

export interface User {
    id: number,
    profile_id: number,
    profile: Profile
}

export interface Organisation {
    id: number,
    name: string
}

export interface Profile {
    id: number,
    username: string
    user_id: number,
    user: User
    team_members: TeamMember[]
}

export interface Event {
    id: number,
    matches: Match[],
    name: string
}

export interface Round {
    id: number,
    matches: Match[],
    name: string | null,
}
