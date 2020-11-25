<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetServicesTable extends Migration
{
    public function up()
    {
        Schema::create('asset_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('asset_id')->unsigned();
            $table->bigInteger('asset_service_type_id')->unsigned();
            $table->text('description');
            $table->integer('quantity');
            $table->bigInteger('asset_unit_id')->unsigned();
            $table->integer('usage_interval');
            $table->bigInteger('asset_usage_type_id')->unsigned();
            $table->string('part_number')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('asset_id')
                ->references('id')
                ->on('assets')
                ->onDelete('cascade');

            $table->foreign('asset_service_type_id')
                ->references('id')
                ->on('asset_service_types')
                ->onDelete('cascade');

            $table->foreign('asset_usage_type_id')
                ->references('id')
                ->on('asset_usage_types')
                ->onDelete('cascade');
        });
        DB::statement('ALTER TABLE asset_services ADD COLUMN time_interval INTERVAL');
    }

    public function down()
    {
        Schema::dropIfExists('asset_services');
    }
}
