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
