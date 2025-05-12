<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTaskStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('labor_type_task_status', function (Blueprint $table) {
            $table->string('sort_order')->nullable();
        });
        DB::statement("UPDATE labor_type_task_status SET sort_order=ts.sort_order FROM task_statuses ts WHERE task_status_id = ts.id;");
        Schema::table('task_statuses', function (Blueprint $table) {
            $table->dropColumn('sort_order')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_statuses', function (Blueprint $table) {
            $table->integer('sort_order')->nullable();
        });
        DB::statement("UPDATE task_statuses SET sort_order=ltts.sort_order::int FROM labor_type_task_status ltts WHERE id = ltts.task_status_id;");
        Schema::table('labor_type_task_status', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });
    }
}
