<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('notes')->nullable();
            $table->integer('activity_level_id');
            $table->integer('property_type_id');
            $table->integer('client_id');
            $table->integer('primary_contact_id')->nullable();
            $table->boolean('work_property')->default(true);
            $table->string('phone_number')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->integer('creator_id');
            $table->integer('updater_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();            
            $table->foreign('activity_level_id')
                ->references('id')->on('activity_levels')
                ->onDelete('SET NULL');            
            $table->foreign('creator_id')
                ->references('id')->on('contacts')
                ->onDelete('RESTRICT');
            $table->foreign('updater_id')
                ->references('id')->on('contacts')
                ->onDelete('RESTRICT');
            $table->foreign('property_type_id')
                ->references('id')->on('property_types')
                ->onDelete('SET NULL');
            $table->foreign('client_id')
                ->references('id')->on('clients')
                ->onDelete('CASCADE');
            $table->foreign('primary_contact_id')
                ->references('id')->on('contacts')
                ->onDelete('SET NULL');
        });
        
        
        Schema::table('clients', function (Blueprint $table) {
            $table->foreign('billing_property_id')
                ->references('id')->on('properties')
                ->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropForeign('clients_billing_property_id_foreign');
        });
        Schema::dropIfExists('properties');
    }
}
