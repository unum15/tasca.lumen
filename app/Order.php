<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'project_id',
		'order_billing_type_id',
        'name',
		'date',
        'approval_date',
        'completion_date',
        'expiration_date',
        'description',
        'order_category_id',
        'order_priority_id',
        'order_type_id',
        'order_status_id',
        'order_action_id',
        'start_date',
        'recurrences',
        'service_window',
        'location',
        'instructions',
        'notes',
        'purchase_order_number',
        'budget',
        'budget_plus_minus',
        'budget_invoice_number',
        'bid',
        'bid_plus_minus',
        'invoice_number',
        'renewable',
        'frequency',
        'renewal_date',
        'notification_lead',
        'renewal_message',
        'creator_id',
        'updater_id'
	];
    
    function project(){
       return $this->belongsTo('App\Project');
    }
}
