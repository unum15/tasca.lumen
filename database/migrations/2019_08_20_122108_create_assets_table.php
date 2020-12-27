<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration
{
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->bigInteger('asset_type_id')->unsigned();
            $table->bigInteger('asset_usage_type_id')->unsigned()->nullable();
            $table->integer('year')->nullable();
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->string('trim')->nullable();
            $table->string('vin')->nullable();
            $table->bigInteger('parent_asset_id')->unsigned()->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            
            $table->foreign('asset_type_id')
                ->references('id')
                ->on('asset_types')
                ->onDelete('cascade');

            $table->foreign('asset_usage_type_id')
                ->references('id')
                ->on('asset_usage_types')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('assets');
    }
}
