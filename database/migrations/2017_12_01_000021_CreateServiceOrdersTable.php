<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->date('approval_date')->nullable();
            $table->date('completion_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->text('description');
            $table->integer('service_order_category_id');
            $table->integer('service_order_priority_id');
            $table->integer('service_order_type_id');
            $table->integer('service_order_status_id');
            $table->integer('service_order_action_id');
            $table->date('start_date');
            $table->integer('recurrences');
            $table->integer('service_window');
            $table->text('location')->nullable();
            $table->text('instructions')->nullable();
            $table->text('notes')->nullable();
            $table->string('purchase_order_number')->nullable();
            $table->float('budget')->nullable();
            $table->integer('budget_plus_minus')->nullable();
            $table->string('budget_invoice_number')->nullable();
            $table->float('bid')->nullable();
            $table->integer('bid_plus_minus')->nullable();
            $table->string('invoice_number')->nullable();
            $table->boolean('renewable');
            $table->integer('frequency')->nullable();
            $table->date('renewal_date')->nullable();
            $table->integer('notification_lead')->nullable();
            $table->text('renewal_message')->nullable();
            $table->integer('creator_id');
            $table->integer('updater_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_orders');
    }
}
