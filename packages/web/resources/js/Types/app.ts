export interface Team {
    id: number
    name: string
    team_members?: TeamMember[]
    match_participants?: MatchParticipant[]
}

export interface TeamMember {
    id: number
    team_id: number
    team?: Team
}

export interface MatchParticipant {
    id: number
    match_id: number,
    match?: Match
    team_id: number
    team?: Team
}

export interface MatchParticipantPlayer {
    id: number
    match_participant_id: number
    match_participant?: MatchParticipant
    team_member_id: number
    team_member?: TeamMember
}

export interface MatchMap {
    id: number
    match_id: number
    match?: Match
    map_id: number
    map?: Map
    scores?: Score[]
}

export interface Map {
    id: number
}

export interface MapPool {
    id: number
    map_pool_maps: Map[]
}

export interface MapPoolMap {
    id: number
    map_pool_id: number
    map_pool?: MapPool
    map_id: number
    map?: Map | null
    mods?: Mod[]
}

export interface Mod {
    id: number
    name: string
}

export interface Match {
    id: number
    map_pool_id: number
    map_pool: MapPool
    match_participants?: MatchParticipant[]
    match_maps?: MatchMap[],
    event_id: number | null,
    event?: Event
    round_id: number | null,
    round?: Round,
    finished_at: string | null,
    current_picker: number | null,
    current_banner: number | null,
    action_limit: string | null
}

export interface Score {
    id: number
    match_participant_player_id: number
    match_participant_player?: MatchParticipantPlayer
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
    user_id: number,
    user?: User
    team_members?: TeamMember[]
}

export interface Event {
    id: number,
    matches?: Match[],
    name: string
}

export interface Round {
    id: number,
    matches?: Match[],
    name: string | null,
}
