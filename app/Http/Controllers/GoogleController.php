<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoogleController extends Controller
{
    private $validation = [
        'name' => 'string|required|min:1|max:255',
        'notes' => 'string|max:255',
        'sort_order' => 'integer',
        'default' => 'boolean',
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getClient()
    {
        $client = new \Google_Client;
        $client->setApplicationName('Tasca Client');
        $client->setScopes(['https://www.googleapis.com/auth/calendar.events', 'https://www.googleapis.com/auth/gmail.send']);
        //$client->setIncludeGrantedScopes(true);

        $client->setAccessType('offline');

        $client->setDeveloperKey(env('GOOGLE_API_KEY'));
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri('http://'.env('GOOGLE_CLIENT_HOST', $_SERVER['HTTP_HOST']).'/google/authorization');

        return $client;
    }

    public function getClientSimple()
    {
        $client = new \Google_Client;
        $client->setApplicationName('Tasca Client');
        $client->setScopes(['https://www.googleapis.com/auth/calendar.events', 'https://www.googleapis.com/auth/gmail.send']);

        $client->setAccessType('offline');

        $client->setDeveloperKey(env('GOOGLE_API_KEY'));
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri('http://'.env('GOOGLE_CLIENT_HOST', $_SERVER['HTTP_HOST']).'/google/authorization');

        return $client;
    }

    public function status(Request $request)
    {
        $token = $request->user()->google_calendar_token;
        if (empty($token)) {
            return ['status' => 'Not Authorized'];
        }
        $client = $this->getClient();
        $client->setAccessToken($token);
        if ($client->isAccessTokenExpired()) {
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                return ['status' => 'Expired'];
            }
        }

        return ['status' => 'Valid'];
    }

    public function url()
    {
        $client = $this->getClient();
        $authUrl = $client->createAuthUrl();

        return ['url' => $authUrl];
    }

    public function callback(Request $request)
    {
        $user = $request->user();
        $code = $request->only('code');
        $client = $this->getClient();
        //$client->setAuthConfig(env('GOOGLE_CLIENT_SECRET'));
        $accessToken = $client->fetchAccessTokenWithAuthCode($code['code']);
        if (isset($accessToken['error'])) {
            error_log($code['code']);
            error_log(print_r($accessToken, true));

            return response(['error' => 'Error communicating with Google.'], 500);
        }
        $client->setAccessToken($accessToken);
        $user->update(['google_calendar_token' => json_encode($accessToken)]);

        return $this->status($request);
    }
}
