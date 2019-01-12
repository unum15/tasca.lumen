<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderActionOrderStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_action_order_status', function (Blueprint $table) {
            $table->integer('order_action_id');
            $table->integer('order_status_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();                        
            $table->unique(['order_action_id', 'order_status_id']);
            $table->foreign('order_action_id')
                ->references('id')->on('order_actions')
                ->onDelete('cascade');
            $table->foreign('order_status_id')
                ->references('id')->on('order_statuses')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_action_order_status');
    }
}
