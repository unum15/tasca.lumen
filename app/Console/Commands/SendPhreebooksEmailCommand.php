<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Contact;
use Log;

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
        
	putenv("GOOGLE_APPLICATION_CREDENTIALS=" . env('GOOGLE_AUTH_CONFIG'));

	$client = new \Google_Client();
	$client->useApplicationDefaultCredentials();
	$client->setSubject(env("GOOGLE_EMAILER"));
        $client->setApplicationName('Tasca');

	$client->setScopes(["https://mail.google.com/",
	                    "https://www.googleapis.com/auth/gmail.compose",
                            "https://www.googleapis.com/auth/gmail.modify",
                            "https://www.googleapis.com/auth/gmail.send"]);
        $service = new \Google_Service_Gmail($client);


        $phreebooksdb = DB::connection('phreebooks');
                
        $sql="
            SELECT
                *
            FROM
                emails
            WHERE
               NOT sent
        ";
        
        $emails = $phreebooksdb->select($sql);

        $sql_attachments="
            SELECT
                *
            FROM
                emails_attachments
            WHERE
               email_id = ?
        ";
        
        
        foreach($emails as $email){
            if($email->to_address == ""){
                continue;
            }
            $from = $email->from_name."<".env('GOOGLE_EMAIL_ALIAS').">";
            $boundary = uniqid(rand(), true);
            $message = new \Google_Service_Gmail_Message();
            $rawMessageString = "From: $from\r\n";
            $rawMessageString .= "To: \"".$email->to_name."\"<".$email->to_address.">\r\n";
            $rawMessageString .= 'Subject: =?utf-8?B?' . base64_encode($email->subject) . "?=\r\n";
            $rawMessageString .= "MIME-Version: 1.0\r\n";
	        $rawMessageString .= 'Content-type: Multipart/Mixed; boundary="' . $boundary . '"' . "\r\n";
        
            $attachments = $phreebooksdb->select($sql_attachments,[$email->id]);
            foreach($attachments as $attachment){
                $rawMessageString .= "\r\n--{$boundary}\r\n";
                $rawMessageString .= 'Content-Type: application/pdf; name="'. $attachment->attachment_name .'";' . "\r\n";            
                $rawMessageString .= 'Content-ID: <' . $email->from_address . '>' . "\r\n";            
                $rawMessageString .= 'Content-Description: ' . $attachment->attachment_name . ';' . "\r\n";
                $words = explode('/', $attachment->attachment_name);
                $filename = trim($words[count($words) - 1], '/');
                $rawMessageString .= 'Content-Disposition: attachment; filename="' . $filename . '.pdf"; size=' . strlen($attachment->attachment). ';' . "\r\n";
                $rawMessageString .= 'Content-Transfer-Encoding: base64' . "\r\n\r\n";
                $rawMessageString .= chunk_split(base64_encode($attachment->attachment), 76, "\n") . "\r\n";
                $rawMessageString .= "--{$boundary}\r\n";
            }
            $rawMessageString .= "Content-Type: text/html; charset=utf-8\r\n";
            $rawMessageString .= 'Content-Transfer-Encoding: quoted-printable' . "\r\n\r\n";
            $rawMessageString .= $email->body . "\r\n";
            $rawMessage = strtr(base64_encode($rawMessageString), array('+' => '-', '/' => '_'));
            $message->setRaw($rawMessage);
            try {
		        $success = $service->users_messages->send("me", $message);
            } catch (\Exception $e) {
                $errorText = $e->getMessage();
                $errorMessage = new \Google_Service_Gmail_Message();
                $errorRaw = "From: $from\r\nTo: $from\r\nSubject: Failed to send message: $errorText\r\n";
                $errorMessage->setRaw(strtr(base64_encode($errorRaw), ['+' => '-', '/' => '_']));
                $service->users_messages->send("me", $errorMessage);
            }
            finally{
                $phreebooksdb->update("UPDATE emails SET sent=true WHERE id=?",[$email->id]);
            }
        }
    }       
}
