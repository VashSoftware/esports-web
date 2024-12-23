export interface Team {
    id: number
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
}

export interface Map {
    id: number
}

export interface Match {
    id: number
    match_participants?: MatchParticipant[]
    match_maps?: MatchMap[]
}

export interface Score { 
    id: number
    match_participant_player_id: number
    match_participant_player?: MatchParticipantPlayer
    score: number
}