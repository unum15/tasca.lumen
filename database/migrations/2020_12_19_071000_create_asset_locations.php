<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetLocations extends Migration
{
    public function up()
    {
        Schema::create('asset_locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('notes')->nullable();
            $table->integer('sort_order')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('asset_locations');
    }
}
