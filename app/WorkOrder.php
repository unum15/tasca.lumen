<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    protected $table = "workorders.workorders";
	protected $primaryKey = "workorder_index";
	public $timestamps = false;
	protected $fillable = [
		'property_index',
		'location',
		'instructions',
		'priority_index', 
        'notes',
		'budget',
		'bid',
		'approval_date',
		'progress_percentage',
		'date_completed', 
        'invoice_number',
		'description',
		'contact_index',
		'deleted',
		'po_number', 
        'workorder_date',
		'approved_by',
		'budget_invoice_number',
		'budget_plus_minus', 
        'bid_plus_minus',
		'work_hours',
		'work_days',
		'expires',
		'status_index', 
        'type_index',
		'action_index',
		'group_name'
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
