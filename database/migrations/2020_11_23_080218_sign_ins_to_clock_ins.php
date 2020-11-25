<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SignInsToClockIns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('clock_ins');
        Schema::rename('sign_ins','clock_ins');
        Schema::table('clock_ins', function (Blueprint $table) {
            $table->renameColumn('sign_in','clock_in');
            $table->renameColumn('sign_out','clock_out');
            $table->foreign('task_date_id')
                ->references('id')->on('task_dates')
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
        Schema::rename('clock_ins','sign_ins');
        Schema::table('sign_ins', function (Blueprint $table) {
            $table->renameColumn('clock_in','sign_in');
            $table->renameColumn('clock_out','sign_out');
        });
    }
}
