<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Contact;
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
        
        $contact = Contact::where('login', env('GOOGLE_EMAILER'))->first();

        $client = new \Google_Client();
        $client->setApplicationName('Tasca');
        $client->setScopes(["https://www.googleapis.com/auth/calendar.events","https://www.googleapis.com/auth/gmail.send"]);        
        $client->setAccessType('offline');
        $client->setDeveloperKey(env('GOOGLE_API_KEY'));
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setAccessToken($contact->google_calendar_token);
        $service = new \Google_Service_Gmail($client);


        /*$phreebooksdb = DB::connection('phreebooks');
                
        $sql="
            SELECT
                *
            FROM
                emails
        ";
        
        $emails = $phreebooksdb->select($sql);
        */
        $from = $contact->name."<".$contact->login.">";
        $emails = [
            [
                'to' => 'Kyle Waters<unum@unum5.org>',
                'subject' => 'Email Subject',
                'body' => 'Email Body',
            ]
        ];
        
        foreach($emails as $email){
            $message = new \Google_Service_Gmail_Message();
            $rawMessageString = "From: $from\r\n";
            $rawMessageString .= "To: ".$email['to']."\r\n";
            $rawMessageString .= 'Subject: =?utf-8?B?' . base64_encode($email['subject']) . "?=\r\n";
            $rawMessageString .= "MIME-Version: 1.0\r\n";
            $rawMessageString .= "Content-Type: text/html; charset=utf-8\r\n";
            $rawMessageString .= 'Content-Transfer-Encoding: quoted-printable' . "\r\n\r\n";
            $rawMessageString .= $email['body'];
            $rawMessage = strtr(base64_encode($rawMessageString), array('+' => '-', '/' => '_'));
            $message->setRaw($rawMessage);
            $message = $service->users_messages->send($contact->login, $message);
        }
    }       
}
