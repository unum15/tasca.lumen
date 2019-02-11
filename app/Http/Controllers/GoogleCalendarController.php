<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoogleCalendarController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $validation = [
        'name' => 'string|required|min:1|max:255',
        'notes' => 'string|max:255',
        'sort_order' => 'integer',
        'default' => 'boolean'        
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    function getClient(){
        $client = new \Google_Client();
        $client->setApplicationName('Tasca');
        $client->setScopes("https://www.googleapis.com/auth/calendar.events");
        
        
        $client->setAccessType('offline');
        //$client->setPrompt('select_account consent');
        
        
        $client->setDeveloperKey(env('GOOGLE_API_KEY'));
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri('http://'.env('GOOGLE_CLIENT_HOST',$_SERVER['HTTP_HOST']).'/calendar');
        return $client;
    }


    function index(){
        $client = getClient();
        $service = new Google_Service_Calendar($client);
        
        // Print the next 10 events on the user's calendar.
        $calendarId = 'primary';
        $optParams = array(
          'maxResults' => 10,
          'orderBy' => 'startTime',
          'singleEvents' => true,
          'timeMin' => date('c'),
        );
        $results = $service->events->listEvents($calendarId, $optParams);
        $events = $results->getItems();
        
        if (empty($events)) {
            print "No upcoming events found.\n";
        } else {
            print "Upcoming events:\n";
            foreach ($events as $event) {
                $start = $event->start->dateTime;
                if (empty($start)) {
                    $start = $event->start->date;
                }
                printf("%s (%s)\n", $event->getSummary(), $start);
            }
        }
    }
    
    function status(Request $request){
        $token = $request->user()->google_calendar_token;
        if(empty($token)){
            return ['status' => 'Not Authorized'];
        }
        $client = $this->getClient();
        $client->setAccessToken(['access_token' => $token]);
        if ($client->isAccessTokenExpired()) {
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            }
            else{
                return ['status' => 'Expired'];
            }
        }
        
        return ['status' => 'Valid'];
    }
    
    function url(){
        $client = $this->getClient();
        $authUrl = $client->createAuthUrl();
        return ['url' => $authUrl];
                /*
                $authCode = trim(fgets(STDIN));
    
                // Exchange authorization code for an access token.
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);
    
                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken)) {
                    throw new Exception(join(', ', $accessToken));
                }
            }
            // Save the token to a file.
            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }
            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        */
    }
    
    function callback(Request $request){
        $user = $request->user();
        $code = $request->only('code');
        $client = $this->getClient();
        $accessToken = $client->fetchAccessTokenWithAuthCode($code['code']);
        if(isset($accessToken['error'])){
            error_log($code['code']);
            error_log(print_r($accessToken,true));
            return response(['error' => 'Error communicating with Google.'], 500);
        }
        $client->setAccessToken($accessToken);
        $user->update(['google_calendar_token' => $accessToken['access_token']]);
        return $this->status($request);
    }
}
