<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddNumberToAssets extends Migration
{

    public function up()
    {
        DB::table('assets')->delete();
        Schema::table('assets', function (Blueprint $table) {
            $table->bigInteger('asset_category_id')->nullable();
            $table->bigInteger('asset_brand_id')->nullable();
            $table->bigInteger('asset_type_id')->nullable()->change();
            $table->bigInteger('asset_group_id')->nullable();
            $table->bigInteger('asset_sub_id')->nullable();
            $table->foreign('asset_category_id')
                ->references('id')->on('asset_categories')
                ->onDelete('cascade');
            $table->foreign('asset_brand_id')
                ->references('id')->on('asset_brands')
                ->onDelete('cascade');
            $table->foreign('asset_group_id')
                ->references('id')->on('asset_groups')
                ->onDelete('cascade');
            $table->foreign('asset_sub_id')
                ->references('id')->on('asset_subs')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn('asset_category_id');
            $table->dropColumn('asset_brand_id');
            $table->dropColumn('asset_group_id');
            $table->dropColumn('asset_sub_id');
        });
    }
}
