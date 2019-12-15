<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackflowCleaningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backflow_cleanings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('backflow_test_report_id');
            $table->integer('contact_id');
            $table->integer('backflow_valve_id');
            $table->integer('backflow_valve_part_id');
            $table->date('cleaned_on');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            
            $table->foreign('backflow_test_report_id')
                ->references('id')
                ->on('backflow_test_reports')
                ->onDelete('cascade');
                
            $table->foreign('contact_id')
                ->references('id')
                ->on('contacts')
                ->onDelete('cascade');
                
            $table->foreign('backflow_valve_id')
                ->references('id')
                ->on('backflow_valves')
                ->onDelete('cascade');
            
            $table->foreign('backflow_valve_part_id')
                ->references('id')
                ->on('backflow_valve_parts')
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
        Schema::dropIfExists('backflow_cleanings');
    }
}
