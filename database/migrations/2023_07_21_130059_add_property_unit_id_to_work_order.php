<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPropertyUnitIdToWorkOrder extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('property_unit_id')->nullable();

            $table->foreign('property_unit_id')
            ->references('id')
            ->on('property_units')
            ->onDelete('cascade');
        });

        Schema::table('logs.orders', function (Blueprint $table) {
            $table->integer('property_unit_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('property_unit_id');
        });
        Schema::table('logs.orders', function (Blueprint $table) {
            $table->dropColumn('property_unit_id');
        });
    }
}
