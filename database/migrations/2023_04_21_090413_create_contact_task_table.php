<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactTaskTable extends Migration
{
    public function up()
    {
        Schema::create('contact_task', function (Blueprint $table) {
            $table->integer('contact_id');
            $table->integer('task_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->unique(['contact_id', 'task_id']);
            $table->foreign('contact_id')
                ->references('id')->on('contacts')
                ->onDelete('cascade');
            $table->foreign('task_id')
                ->references('id')->on('tasks')
                ->onDelete('cascade');
        });
        Schema::dropIfExists('task_contact_assigned');
        DB::statement('update orders set contact_id = projects.contact_id from projects where projects.id = orders.project_id');
    }

    public function down()
    {
        Schema::dropIfExists('contact_task');
        DB::statement('update orders set contact_id = null');
    }
}
