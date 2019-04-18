<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveDatesToTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->date('closed_date')->nullable();
            $table->date('billed_date')->nullable();
        });
        $db = DB::connection();
        $db->update("UPDATE tasks SET closed_date = completion_date");
        $db->update("UPDATE tasks SET completion_date =  null");
        $sql = "
            UPDATE 
                tasks
            SET
                completion_date = last_completion_date,
                billed_date = last_billed_date
            FROM
                (
                    SELECT
                        task_id,
                        MAX(completion_date) AS last_completion_date,
                        MAX(billed_date) AS last_billed_date
                    FROM
                        task_dates
                    GROUP BY
                        task_id
                ) task_dates
            WHERE
                tasks.id = task_dates.task_id
        ";
        $db->update($sql);
        Schema::table('task_dates', function (Blueprint $table) {
            $table->dropColumn('completion_date');
            $table->dropColumn('billed_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_dates', function (Blueprint $table) {
            $table->date('completion_date')->nullable();
            $table->date('billed_date')->nullable();
        });
        $db = DB::connection();
        $sql = "
            UPDATE 
                task_dates
            SET
                completion_date = tasks.completion_date,
                billed_date = tasks.billed_date
            FROM
                (
                    SELECT
                        id,
                        completion_date,
                        billed_date
                    FROM
                        tasks
                ) tasks
            WHERE
                tasks.id = task_dates.task_id
        ";
        $db->update($sql);
        $db->update("UPDATE tasks SET completion_date = closed_date");
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('closed_date');
            $table->dropColumn('billed_date');
        });
    }
}
