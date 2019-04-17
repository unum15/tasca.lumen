<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveSignInsToTaskDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sign_ins', function (Blueprint $table) {
            $table->integer('task_date_id')->default(0);
        });
        $db = DB::connection();
        $sql="
            SELECT
                sign_ins.id,
                order_id,
                sign_in
            FROM
                sign_ins
                LEFT JOIN orders ON (sign_ins.order_id = orders.id)
            ORDER BY
                sign_ins.id
        ";
        
        $sign_ins = $db->select($sql);
        foreach($sign_ins as $sign_in){
            $td_sql="
                SELECT
                    task_dates.id,
                    task_dates.date
                FROM
                    tasks
                    LEFT JOIN task_dates ON (tasks.id = task_dates.task_id)
                WHERE
                    order_id = ?
                    AND date = ?::DATE
            ";
        
            $task_dates = $db->select($td_sql, [$sign_in->order_id, $sign_in->sign_in]);
            
            if(!empty($task_dates)){
                $db->update("UPDATE sign_ins SET task_date_id = ? WHERE id=?", [$task_dates[0]->id, $sign_in->id]);
                continue;
            }
            $td_sql="
                SELECT
                    id
                FROM
                    tasks
                WHERE
                    order_id = ?
            ";
        
            $tasks = $db->select($td_sql, [$sign_in->order_id]);
            if(count($tasks) >= 1){
                $db->insert("
                    INSERT INTO public.task_dates
                    (task_id, date, notes, creator_id, updater_id, completion_date, billed_date)
                    VALUES (?, ?::DATE, 'Match Sign In', 1, 1, ?::DATE, ?::DATE);
                ",[$tasks[0]->id,$sign_in->sign_in,$sign_in->sign_in,$sign_in->sign_in]);
                $id = DB::select('select lastval() AS id');
                $task_dates = DB::select('select * from task_dates WHERE id = ?', [$id[0]->id]);
                $db->update("UPDATE sign_ins SET task_date_id = ? WHERE id=?", [$id[0]->id, $sign_in->id]);
                continue;    
            }
            echo $sign_in->order_id.":".count($tasks)."\n";
        }
        Schema::table('sign_ins', function (Blueprint $table) {
            $table->dropColumn('order_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sign_ins', function (Blueprint $table) {
            $table->integer('order_id')->default(0);
        });
        $db = DB::connection();
        $sql="
            SELECT
                sign_ins.id,
                tasks.order_id,
                sign_in
            FROM
                sign_ins
                LEFT JOIN task_dates ON (sign_ins.task_date_id = task_dates.id)
                LEFT JOIN tasks ON (task_dates.task_id = tasks.id)
            ORDER BY
                sign_ins.id
        ";
        
        $sign_ins = $db->select($sql);
        foreach($sign_ins as $sign_in){
            $db->update("UPDATE sign_ins SET order_id = ? WHERE id=?", [$sign_in->order_id, $sign_in->id]);
        }
        Schema::table('sign_ins', function (Blueprint $table) {
            $table->dropColumn('task_date_id');
        });
        $db->delete("DELETE FROM task_dates WHERE notes='Match Sign In'");
    }
}
