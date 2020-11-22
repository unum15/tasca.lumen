<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOverheadAssignments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overhead_assignments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('notes')->nullable();
            $table->integer('sort_order')->nullable();
            $table->bigInteger('parent_id')->nullable();
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
        Schema::dropIfExists('overhead_assignments');
    }
}
