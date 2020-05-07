<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Task;
use App\TaskDate;

class CloseOrdersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:closeOrders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Closes all orders older than 30 days for which there is no open tasks.';

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
        $sql = "
            UPDATE orders
            SET completion_date = oo.last_closed_date + '30 days'::INTERVAL
            FROM (SELECT
                o.id,
                t.last_closed_date
            FROM
                orders o
                LEFT JOIN (
                    SELECT
                        order_id,
                        COUNT(CASE WHEN closed_date IS NULL THEN 1 ELSE NULL END) AS open_tasks,
                        MAX(closed_date) AS last_closed_date
                    FROM
                        tasks
                    GROUP BY
                        order_id
                ) t ON (o.id = t.order_id)
            WHERE
                o.completion_date IS NULL
                AND (o.expiration_date >= NOW()::DATE OR o.expiration_date IS NULL)
                AND last_closed_date IS NOT NULL
                AND open_tasks = 0
                AND o.date <= '2019-06-30'
            GROUP BY
                o.id,
                t.last_closed_date
            ) oo
            WHERE
                orders.id = oo.id
        ";
        DB::update($sql);
    }
}
