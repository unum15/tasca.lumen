<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewAssetFields extends Migration
{
    public function up()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->bigInteger('asset_location_id')->nullable();
            $table->string('manufacture')->nullable();
            $table->string('number')->nullable();
            $table->decimal('purchase_cost')->nullable();
            $table->date('purchase_date')->nullable();

            $table->foreign('asset_location_id')
                ->references('id')
                ->on('asset_locations')
                ->onDelete('cascade');
        });
        
        
    }

    public function down()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn('manufacture');
            $table->dropColumn('number');
            $table->dropColumn('purchase_cost');
            $table->dropColumn('purchase_date');
            $table->dropColumn('asset_location_id');
        });
    }
}
