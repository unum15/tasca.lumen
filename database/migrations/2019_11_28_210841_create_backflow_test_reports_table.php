<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackflowTestReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backflow_test_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('backflow_assembly_id');
            $table->string('visual_inspection_notes')->nullable();
            $table->string('notes')->nullable();
            $table->boolean('backflow_installed_to_code')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->foreign('backflow_assembly_id')
                ->references('id')
                ->on('backflow_assemblies')
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
        Schema::dropIfExists('backflow_test_reports');
    }
}
