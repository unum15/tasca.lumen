<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    protected $fillable = [
		'date',
        'approval_date',
        'completion_date',
        'expiration_date',
        'description',
        'category_id',
        'service_order_priority_id',
        'service_order_type_id',
        'service_order_status_id',
        'service_order_action_id',
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
}
