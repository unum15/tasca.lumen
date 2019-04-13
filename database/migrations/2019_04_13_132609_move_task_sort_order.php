<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveTaskSortOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_dates', function (Blueprint $table) {
            $table->string('sort_order')->nullable();
        });
        DB::statement("UPDATE task_dates SET sort_order = tasks.sort_order FROM (SELECT id,sort_order FROM  tasks) AS tasks WHERE task_dates.task_id=tasks.id;");
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('sort_order');
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
            $table->string('sort_order')->nullable();
        });
        DB::statement("UPDATE tasks SET sort_order = task_dates.sort_order FROM (SELECT task_id,sort_order FROM task_dates) AS task_dates WHERE task_dates.task_id=tasks.id;");        
        Schema::table('task_dates', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });
    }
}
