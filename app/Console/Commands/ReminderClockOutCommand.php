<?php

namespace App\Console\Commands;

use App\ClockIn;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ReminderClockOutCommand extends Command
{
    protected $signature = 'reminder:clockout';
    protected $description = 'Closes all orders older than 30 days for which there is no open tasks.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $clock_ins = ClockIn::with(
            'contact',
            'contact.emails'
        )
        ->whereNull('clock_out')
        ->get();

        $from_address = env('MAIL_FROM_ADDRESS','admin@tasca.app');
        $from_name = env('MAIL_FROM_NAME','Tasca Administrator');

        foreach($clock_ins as $clock_in){
            if(count($clock_in->contact->emails)){
                $email = $clock_in->contact->emails[0]->email;
                $name = $clock_in->contact->name;
                $body = $name;
                $body .= ",\n\nYou clocked in at ". $clock_in->clock_in .", but you did not clock out. Are you really still working on that job?\n\n";
                $body .= "Sincerely,\n Tasca\n";
                 Mail::raw($body, function ($message) use ($from_address, $from_name, $email, $name) {
                    $message->from($from_address, $from_name);
                    $message->to($email,$name)->subject('Clock Out Reminder');
                });
                
            }
        }
    }
}
