<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->boolean('billable');
            $table->string('description')->nullable();
            $table->integer('order_id')->nullable();
            $table->integer('task_type_id')->nullable();
            $table->integer('task_category_id')->nullable();
            $table->integer('task_status_id')->nullable();
            $table->integer('task_action_id')->nullable();
            $table->integer('task_appointment_status_id')->nullable();
            $table->boolean('hide')->default(false);
            $table->string('day')->nullable();
            $table->date('date')->nullable();
            $table->date('completion_date')->nullable();
            $table->string('time')->nullable();
            $table->string('group')->nullable();
            $table->string('sort')->nullable();
            $table->integer('job_hours')->nullable();
            $table->integer('crew_hours')->nullable();
            $table->text('notes')->nullable();
            $table->integer('sort_order')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
