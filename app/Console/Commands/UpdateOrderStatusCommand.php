<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Task;
use App\TaskDate;
use App\Setting;
use App\Order;

class UpdateOrderStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:updateOrderStatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates order statuses based on dates.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $settings = Setting::all();
        $pending_days_out = 7;
        $date = date_create();
        $date->modify('- ' . $pending_days_out . 'days');
        $orders = Order::
        where('order_status_type_id','2')
        ->where('start_date', '>', $date->format('Y-m-d'))
        ->get();
       
    
        foreach($orders as $order){
            $order->update(['order_status_type_id' => 2]);
        }
    }
}
