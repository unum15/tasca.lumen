<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('notes')->nullable();
            $table->string('referred_by')->nullable();
            $table->integer('client_type_id')->nullable();
            $table->integer('activity_level_id')->nullable();
            $table->integer('contact_method_id')->nullable();
            $table->integer('billing_contact_id')->nullable();
            $table->integer('main_mailing_property_id')->nullable();
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
            $table->foreign('creator_id')
                ->references('id')->on('contacts')
                ->onDelete('RESTRICT');
            $table->foreign('updater_id')
                ->references('id')->on('contacts')
                ->onDelete('RESTRICT');
            $table->foreign('client_type_id')
                ->references('id')->on('client_types')
                ->onDelete('SET NULL');
            $table->foreign('billing_contact_id')
                ->references('id')->on('contacts')
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
        Schema::dropIfExists('clients');
    }
}
