<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskTypeTaskActionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_action_task_type', function (Blueprint $table) {
            $table->integer('task_type_id');
            $table->integer('task_action_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();                        
            $table->unique(['task_type_id', 'task_action_id']);
            $table->foreign('task_type_id')
                ->references('id')->on('task_types')
                ->onDelete('cascade');
            $table->foreign('task_action_id')
                ->references('id')->on('task_actions')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_action_task_type');
    }
}
