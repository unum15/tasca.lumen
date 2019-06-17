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
            WHERE
                task_dates.task_id = tasks.id            
        ";
        
        $db->update($sql);
        Schema::table('Tasks', function (Blueprint $table) {
            //$table->drop('task_appointment_status_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Tasks', function (Blueprint $table) {
            //$table->integer('task_appointment_status_id')->nullable();
        });
        Schema::table('task_dates', function (Blueprint $table) {
            $table->drop('appointment_status_id');
        });
    }
}
