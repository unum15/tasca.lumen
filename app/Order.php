<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'project_id',
		'order_status_type_id',
        'name',
		'date',
        'completion_date',
        'expiration_date',
        'approval_date',
		'start_date',
        'description',
        'order_category_id',
        'order_priority_id',
        'order_type_id',
        'order_status_id',
        'order_action_id',
        'recurrences',
        'service_window',
        'recurring',
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
        'renewal_date',
        'notification_lead',
        'renewal_message',
        'recurring_interval',
        'renewal_interval',
        'creator_id',
        'updater_id'
	];
    
    function project(){
       return $this->belongsTo('App\Project');
    }
    
    function orderAction(){
       return $this->belongsTo('App\OrderAction');
    }
    
    function orderStatusType(){
       return $this->belongsTo('App\OrderStatusType');
    }
    
    function orderCategory(){
       return $this->belongsTo('App\OrderCategory');
    }
    
    function orderPriority(){
       return $this->belongsTo('App\OrderPriority');
    }
    
    function orderStatus(){
       return $this->belongsTo('App\OrderStatus');
    }
    
    function orderType(){
       return $this->belongsTo('App\OrderType');
    }
    
    function tasks(){
        return $this->hasMany('App\Task');
    }
    
    function approver(){
        return $this->belongsTo('App\Contact');
    }
    
    public function properties(){
        return $this->belongsToMany('App\Property')
            ->withTimestamps();
    }
    
    public function signIns(){
        return $this->hasMany('App\SignIn')->orderBy('sign_in');
    }
    
}
