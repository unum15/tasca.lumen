<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Setting;
use App\Order;

class OrderStatusCommand extends Command
{
    protected $signature = 'order:status';

    protected $description = 'Updates order statuses based on dates.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $settings = Setting::all();
        $pending_days_out = 7;
        $date = date_create();
        $date->modify('- ' . $pending_days_out . 'days');
        $orders = Order::
        where('order_status_type_id','2')
        ->where('start_date', '<=', $date->format('Y-m-d'))
        ->get();
       
    
        foreach($orders as $order){
            $order->update(['order_status_type_id' => 2]);
        }
    }
}
