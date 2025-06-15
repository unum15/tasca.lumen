<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTaskActions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('labor_type_task_action', function (Blueprint $table) {
            $table->string('sort_order')->nullable();
        });
        DB::statement("UPDATE labor_type_task_action SET sort_order=ta.sort_order FROM task_actions ta WHERE task_action_id = ta.id;");
        Schema::table('task_actions', function (Blueprint $table) {
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
        Schema::table('task_actions', function (Blueprint $table) {
            $table->integer('sort_order')->nullable();
        });
        DB::statement("UPDATE task_actions SET sort_order=ltta.sort_order::int FROM labor_type_task_action ltta WHERE id = ltta.task_action_id;");
        Schema::table('labor_type_task_action', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });
    }
}
