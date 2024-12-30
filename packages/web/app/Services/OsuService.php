<?php

namespace App\Services;

use App\Models\MatchParticipantPlayer;
use App\Models\VashMatch;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class OsuService
{
    public function __construct() {}

    public function getAccessToken()
    {
        if (Cache::has('osu_access_token')) {
            return Cache::get('osu_access_token');
        }

        $response = Http::asForm()->acceptJson()->post('https://osu.ppy.sh/oauth/token', [
            'client_id' => env('OSU_CLIENT_ID'),
            'client_secret' => env('OSU_CLIENT_SECRET'),
            'grant_type' => 'client_credentials',
            'scope' => 'public',
        ]);

        if ($response->successful()) {
            $data = $response->json();
            Cache::put('osu_access_token', $data['access_token'], $data['expires_in']);

            return $data['access_token'];
        }

        $response->throw();
    }

    public function get($endpoint, $params = [])
    {
        $accessToken = $this->getAccessToken();

        $response = Http::withToken($accessToken)->get("https://osu.ppy.sh/api/v2/$endpoint", $params);

        if ($response->successful()) {
            return $response->json();
        }

        $response->throw();
    }

    public function sendIRCMessage(string $channel, string $message)
    {
        Http::post('osu:'.env('OSU_PORT').'/send-message', [
            'channel' => $channel,
            'message' => $message,
        ]);
    }

    public function makeOsuLobby(int $matchId)
    {
        $match = VashMatch::with('matchParticipants.team')->find($matchId);

        $teamA = $match->matchParticipants[0]->team->name;
        $teamB = $match->matchParticipants[1]->team->name;
        $title = 'VASH: ('.$teamA.') vs ('.$teamB.')';

        $this->sendIRCMessage('BanchoBot', '!mp make '.$title);
    }

    public function setSettings(int $matchId, int $teamMode, int $scoreMode, int $size)
    {
        $match = VashMatch::find($matchId);

        $this->sendIRCMessage('#mp_'.$match->osu_lobby, '!mp set '.$teamMode.' '.$scoreMode.' '.$size);
    }

    public function getMatchSettings(int $matchId)
    {
        $match = VashMatch::find($matchId);

        $this->sendIRCMessage($match->osu_lobby, '!mp settings');
    }

    public function inviteMatchPlayer(int $matchParticipantPlayerId)
    {
        $matchParticipantPlayer = MatchParticipantPlayer::find($matchParticipantPlayerId);

        $playerOsuName = $matchParticipantPlayer->teamMember->profile->platforms()->where('platforms.name', 'osu!')->first()->pivot->name;

        $this->sendIRCMessage('#mp_'.$matchParticipantPlayer->matchParticipant->vashMatch->osu_lobby, '!mp invite '.$playerOsuName);
    }

    public function updatePlayerStatus(int $matchParticipantPlayerId)
    {
        $matchParticipantPlayer = MatchParticipantPlayer::find($matchParticipantPlayerId);

        $this->sendIRCMessage($matchParticipantPlayer->matchParticipant()->vashMatch()->osu_lobby, '!mp status Stan');
    }

    public function setPlayerTeam(int $playerId, int $teamColor)
    {
        $this->sendIRCMessage('BanchoBot', '!mp move Stan 0');
    }

    public function movePlayer(int $playerId, int $position)
    {
        $this->sendIRCMessage('BanchoBot', '!mp move Stan 0');
    }

    public function setMap(array $modIds)
    {
        $match = VashMatch::find($matchId);

        $this->sendIRCMessage('BanchoBot', '!mp map '.'1'.'0');
    }

    public function setMods(array $modIds)
    {
        $match = VashMatch::find($matchId);

        $this->sendIRCMessage('BanchoBot', '!mp make '.'VASH'.': ('.'Stan'.') vs ('.'Stan'.')');
    }

    public function abortMap(int $matchId)
    {
        $match = VashMatch::find($matchId);

        $this->sendIRCMessage($match->osu_lobby, '!mp abort');
    }

    public function closeLobby(int $matchId)
    {
        $match = VashMatch::find($matchId);

        $this->sendIRCMessage('#mp_'.$match->osu_lobby, '!mp close');
    }
}
