<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveAppointmentStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_dates', function (Blueprint $table) {
            $table->integer('appointment_status_id')->nullable();
        });
        $db = DB::connection();
        $sql="
            UPDATE
                task_dates
            SET
                appointment_status_id = task_appointment_status_id
            FROM
                (
                    SELECT
                        id,
                        task_appointment_status_id
                    FROM
                        tasks
                ) AS tasks
            WHERE
                task_dates.task_id = tasks.id            
        ";
        
        $db->update($sql);
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('task_appointment_status_id');
        });
        Schema::table('logs.tasks', function (Blueprint $table) {
            $table->dropColumn('task_appointment_status_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->integer('task_appointment_status_id')->nullable();
        });
        Schema::table('logs.tasks', function (Blueprint $table) {
            $table->integer('task_appointment_status_id')->nullable();
        });
         $sql="
            UPDATE
                tasks
            SET
                task_appointment_status_id = appointment_status_id
            FROM
                (
                    SELECT
                        task_id,
                        appointment_status_id
                    FROM
                        task_dates
                ) AS task_dates
            WHERE
                task_dates.task_id = tasks.id            
        ";
        
        $db->update($sql);

        Schema::table('task_dates', function (Blueprint $table) {
            $table->dropColumn('appointment_status_id');
        });
    }
}
