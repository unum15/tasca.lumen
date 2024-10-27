<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'order_status_type_id',
        'approver_id',
        'name',
        'date',
        'close_date',
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
        'property_unit_id',
        'renewable',
        'renewal_count',
        'renewal_date',
        'notification_lead',
        'renewal_message',
        'recurring_interval',
        'renewal_interval',
        'progress_percentage',
        'contact_id',
        'creator_id',
        'updater_id',
        'work_days',
    ];

    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    public function orderAction()
    {
        return $this->belongsTo('App\OrderAction');
    }

    public function orderStatusType()
    {
        return $this->belongsTo('App\OrderStatusType');
    }

    public function orderCategory()
    {
        return $this->belongsTo('App\OrderCategory');
    }

    public function orderPriority()
    {
        return $this->belongsTo('App\OrderPriority');
    }

    public function orderStatus()
    {
        return $this->belongsTo('App\OrderStatus');
    }

    public function orderType()
    {
        return $this->belongsTo('App\OrderType');
    }

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

    public function approver()
    {
        return $this->belongsTo('App\Contact');
    }

    public function properties()
    {
        return $this->belongsToMany('App\Property')
            ->withTimestamps();
    }

    public function propertyUnit()
    {
        return $this->belongsTo('App\PropertyUnit');
    }
}
