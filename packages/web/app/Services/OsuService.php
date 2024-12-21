<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use WebSocket;

class OsuService
{
    public function __construct()
    {
        // $this->listenForMessages();
    }

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

    public function listenForMessages()
    {
        $client = new WebSocket\Client('wss://osu.ppy.sh/api/v2');

        $accessToken = $this->getAccessToken();
        $client
            ->addMiddleware(new WebSocket\Middleware\CloseHandler)
            ->addMiddleware(new WebSocket\Middleware\PingResponder)
            ->addHeader('Authorization', "Bearer {$accessToken}");

        $data = [
            'event' => 'chat.start',
        ];
        $json = json_encode($data, JSON_PRETTY_PRINT);
        $client->text($json);
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
}
