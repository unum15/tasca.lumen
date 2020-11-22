<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOverheadColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sign_ins', function (Blueprint $table) {
            $table->integer('overhead_assignment_id')->nullable();
            $table->integer('overhead_category_id')->nullable();
            $table->integer('task_date_id')->nullable()->change();
            $table->foreign('overhead_assignment_id')
                ->references('id')
                ->on('overhead_assignments')
                ->onDelete('cascade');
            $table->foreign('overhead_category_id')
                ->references('id')
                ->on('overhead_categories')
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
        Schema::table('sign_ins', function (Blueprint $table) {
            $table->dropColumn('overhead_assignment_id');
            $table->dropColumn('overhead_category_id');
            $table->integer('task_date_id')->change();
        });
    }
}
