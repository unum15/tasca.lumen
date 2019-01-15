<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskTypeTaskCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_category_task_type', function (Blueprint $table) {
            $table->integer('task_type_id');
            $table->integer('task_category_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();                        
            $table->unique(['task_type_id', 'task_category_id']);
            $table->foreign('task_type_id')
                ->references('id')->on('task_types')
                ->onDelete('cascade');
            $table->foreign('task_category_id')
                ->references('id')->on('task_categories')
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
        Schema::dropIfExists('task_category_task_type');
    }
}
