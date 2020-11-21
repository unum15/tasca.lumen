<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBackflowAssembliesFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('backflow_assemblies', function (Blueprint $table) {
            $table->bigInteger('property_account_id')->nullable();
            $table->boolean('need_access')->default(false);
            
            $table->foreign('property_account_id')
                ->references('id')
                ->on('property_accounts')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('backflow_assemblies', function (Blueprint $table) {
            //
        });
    }
}
