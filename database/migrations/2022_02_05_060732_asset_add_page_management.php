<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AssetAddPageManagement extends Migration
{
    public function up()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn('asset_usage_type_id');
            $table->boolean('needs_maintenances')->default(false);
            $table->boolean('needs_parts')->default(false);
            $table->boolean('needs_repairs')->default(false);
            $table->boolean('needs_fuelings')->default(false);
            $table->boolean('needs_services')->default(false);
        });
    }

    public function down()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->integer('asset_usage_type_id')->nullable();
            $table->dropColumn('needs_maintenances');
            $table->dropColumn('needs_parts');
            $table->dropColumn('needs_repairs');
            $table->dropColumn('needs_fuelings');
            $table->dropColumn('needs_services');
        });
    }
}
