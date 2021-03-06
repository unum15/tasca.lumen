<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('notes')->nullable();
            $table->integer('activity_level_id')->nullable();
            $table->integer('contact_method_id')->nullable();
            $table->string('login')->nullable();
            $table->binary('password')->nullable();
            $table->string('google_calendar_token', 2048)->nullable();
            $table->string('google_calendar_id')->nullable();
            $table->boolean('show_help')->default(true);
            $table->integer('show_maximium_activity_level_id')->nullable();
            $table->integer('default_service_window')->default(7);
            $table->integer('pending_days_out')->default(7);
            $table->boolean('fluid_containers')->default(true);
            $table->integer('creator_id');
            $table->integer('updater_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->foreign('activity_level_id')
                ->references('id')->on('activity_levels')
                ->onDelete('SET NULL');
            $table->foreign('contact_method_id')
                ->references('id')->on('contact_methods')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
