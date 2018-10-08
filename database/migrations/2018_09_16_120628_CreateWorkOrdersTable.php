<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id');
            $table->date('completion_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->integer('priority_id')->nullable();
            $table->integer('work_type_id')->nullable();
            $table->integer('crew')->nullable();
            $table->integer('total_hours')->nullable();
            $table->string('location')->nullable();
            $table->string('instructions')->nullable();
            $table->string('notes')->nullable();
            $table->string('purchase_order_number')->nullable();
            $table->string('budget')->nullable();
            $table->integer('budget_plus_minus')->nullable();
            $table->string('budget_invoice_number')->nullable();
			$table->string('bid')->nullable();
			$table->string('bid_plus_minus')->nullable();
            $table->integer('invoice_number')->nullable();
            $table->integer('creator_id');
            $table->integer('updater_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            
            
/*            
            
        'property_id',    
		'approval_date',
		'progress_percentage',		
		'description',
		'contact_index',
		'deleted',		
        'workorder_date',
		'approved_by',
		'budget_invoice_number',        
		'work_hours',
		'work_days',
		'status_index', 
		'action_index',
		'group_name'
  */          
            
            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_orders');
    }
}
