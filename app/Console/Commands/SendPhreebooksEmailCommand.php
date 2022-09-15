<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
#use Google\Client;
#use Google\Service\Gmail;

class SendPhreebooksEmailCommand extends Command
{
    protected $signature = 'db:email';
    protected $description = 'Send email from phreebooks';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $phreebooksdb = DB::connection('phreebooks');
                
        $sql="
            SELECT
                *
            FROM
                emails
        ";
        
        $emails = $phreebooksdb->select($sql);
        
        
        foreach($emails as $email){
        }

	$client = new \Google_Client();
        $client->setApplicationName('Tasca');
        $client->setScopes(["https://www.googleapis.com/auth/calendar.events","https://www.googleapis.com/auth/gmail.send"]);        
        $client->setAccessType('offline');
        $client->setDeveloperKey(env('GOOGLE_API_KEY'));
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
	$client->setAccessToken("ya29.A0AVA9y1sqihmGKBAVw0pgJbMOhG75iV8R8-I8bMQe58b0XfLz07ZZnz_n3cK5UFXhimZO_SkAiBpsSntjoIdOg4yOdOK8MF9JKWw4JW80TaVkF1h8_uV4ayWnWvG38F-_f1rMMWayV28h4EYnwF9AEt5qeSWAYUNnWUtBVEFTQVRBU0ZRRTY1ZHI4YUpRcWo2Rndvcjh2MVdRUGJiWFVldw0163");
//        $client->setRedirectUri('http://'.env('GOOGLE_CLIENT_HOST', $_SERVER['HTTP_HOST']).'/google/authorization');
	$service = new \Google_Service_Gmail($client);
	$message = new \Google_Service_Gmail_Message();
	$rawMessageString = "From: <kyle@waterscontracting.com>\r\n";
	$rawMessageString .= "To: <unum@unum5.org>\r\n";
	$rawMessageString .= 'Subject: =?utf-8?B?' . base64_encode("test") . "?=\r\n";
	$rawMessageString .= "MIME-Version: 1.0\r\n";
	$rawMessageString .= "Content-Type: text/html; charset=utf-8\r\n";
	$rawMessageString .= 'Content-Transfer-Encoding: quoted-printable' . "\r\n\r\n";
	$rawMessageString .= "test 123\r\n";
	$rawMessage = strtr(base64_encode($rawMessageString), array('+' => '-', '/' => '_'));
	$message->setRaw($rawMessage);
	$message = $service->users_messages->send("kyle@waterscontracting.com", $message);
    }       
}
