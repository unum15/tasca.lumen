<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{    
	protected $fillable = [
		'completion_date',
		'expiration_date',
        'priority_id',
        'work_type_id',
        'crew',
        'total_hours',
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
        'creator_id',
        'updater_id'
        
	];
	
	
	public function Contact(){
		return $this->belongsTo('App\Contact', 'contact_index', 'contact_index');
	}
	
	
	public function Priority(){
		return $this->belongsTo('App\Priority', 'priority_index', 'priority_index');
	}
	
	public function Property(){
		return $this->belongsTo('App\Property', 'property_index', 'property_index');
	}
	
	public function ApprovedBy(){
		return $this->belongsTo('App\Contact', 'approved_by', 'contact_index');
	}
	
	public function Status(){
		return $this->belongsTo('App\Model\WorkOrder\Status', 'status_index', 'status_index');
	}
	
	public function Type(){
		return $this->belongsTo('App\Model\WorkOrder\Type', 'type_index', 'type_index');
	}
	
	public function Action(){
		return $this->belongsTo('App\Model\WorkOrder\Action', 'action_index', 'action_index');
	}
	
	public function Tasks(){
		return $this->hasMany('App\Model\Task\Task', 'workorder_index', 'workorder_index')->orderBy('schedule_index');
	}
	
}
