<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{    
	protected $fillable = [
		'project_id',
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
	
	
	public function Priority(){
		return $this->belongsTo('App\Priority');
	}
	
	public function WorkType(){
		return $this->belongsTo('App\WorkType');
	}
		
	public function Tasks(){
		return $this->hasMany('App\Task')->orderBy('schedule_index');
	}
	
	public function Project(){
		return $this->belongsTo('App\Project');
	}
}
