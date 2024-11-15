<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OsuService
{
    public function getAccessToken()
    {
        if (Cache::has('osu_access_token')) {
            return Cache::get('osu_access_token');
        }

        $response = Http::asForm()->acceptJson()->post("https://osu.ppy.sh/oauth/token", [
            'client_id' => env('OSU_CLIENT_ID'),
            'client_secret' => env('OSU_CLIENT_SECRET'),
            'grant_type' => 'client_credentials',
            'scope' => 'public'
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
}
