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
        Schema::table('task_actions', function (Blueprint $table) {
            $table->string('sort_order', 4)->nullable()->change();
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
            DB::statement('ALTER TABLE task_actions ALTER sort_order  TYPE integer USING (sort_order::integer);');
        });
    }
}
