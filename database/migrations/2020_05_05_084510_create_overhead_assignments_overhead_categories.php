<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOverheadAssignmentsOverheadCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overhead_assignment_overhead_category', function (Blueprint $table) {
            $table->integer('overhead_assignment_id');
            $table->integer('overhead_category_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->unique(['overhead_assignment_id', 'overhead_category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('overhead_assignment_overhead_category');
    }
}
