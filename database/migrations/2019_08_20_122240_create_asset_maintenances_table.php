<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetMaintenancesTable extends Migration
{
    public function up()
    {
        Schema::create('asset_maintenances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('asset_service_id')->unsigned();
            $table->bigInteger('asset_usage_type_id')->unsigned();
            $table->integer('usage')->nullable();
            $table->date('date')->nullable();
            $table->double('amount')->nullable();
            $table->string('where')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('asset_service_id')
                ->references('id')
                ->on('asset_services')
                ->onDelete('cascade');

            $table->foreign('asset_usage_type_id')
                ->references('id')
                ->on('asset_usage_types')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('asset_maintenances');
    }
}
