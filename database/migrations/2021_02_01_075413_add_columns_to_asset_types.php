<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddColumnsToAssetTypes extends Migration
{
    public function up()
    {
        DB::table('asset_types')->delete();
        Schema::table('asset_types', function (Blueprint $table) {
            $table->bigInteger('asset_brand_id');
            $table->char('number',1);
            $table->string('sort_order')->change();
            $table->foreign('asset_brand_id')
                ->references('id')->on('asset_brands')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('asset_types', function (Blueprint $table) {
            $table->dropColumn('asset_brand_id');
            $table->dropColumn('number');
        });
    }
}
