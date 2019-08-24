<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('vehicle_id')->unsigned();
            $table->integer('service_type_id')->unsigned();
            $table->text('description');
            $table->integer('quantity');
            $table->integer('usage_type_id')->unsigned();
            $table->integer('usage_interval');
            $table->string('part_number')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('vehicle_id')
                ->references('id')
                ->on('vehicles')
                ->onDelete('cascade');

            $table->foreign('service_type_id')
                ->references('id')
                ->on('service_types')
                ->onDelete('cascade');

            $table->foreign('usage_type_id')
                ->references('id')
                ->on('usage_types')
                ->onDelete('cascade');
        });
        DB::statement('ALTER TABLE services ADD COLUMN time_interval INTERVAL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
