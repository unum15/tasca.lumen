<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TaskDatesCompletionBilling extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_dates', function (Blueprint $table) {
            $table->date('completion_date')->nullable();
            $table->date('billed_date')->nullable();
        });
        DB::statement("UPDATE task_dates SET completion_date=\"date\",billed_date=\"date\" WHERE date<'2019-01-01'");
        DB::statement("UPDATE task_dates SET completion_date=\"date\" WHERE date>='2019-01-01' AND date<NOW()::DATE AND task_id =ANY (SELECT tasks.id FROM orders LEFT JOIN tasks ON (tasks.order_id = orders.id) WHERE approval_date IS NOT NULL);");
        DB::statement("UPDATE task_dates SET billed_date=\"date\" WHERE date>='2019-01-01' AND date<NOW()::DATE-'1 month'::INTERVAL AND task_id =ANY (SELECT tasks.id FROM orders LEFT JOIN tasks ON (tasks.order_id = orders.id) WHERE approval_date IS NOT NULL);");
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_dates', function (Blueprint $table) {
            $table->dropColumn('completion_date');
            $table->dropColumn('billed_date');
        });
    }
}
