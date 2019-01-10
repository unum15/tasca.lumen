<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $validation = [
        'description' => 'string|min:1|max:255',
		'project_id' => 'integer|exists:projects,id',
        'order_billing_type_id' => 'integer|exists:order_billing_types,id',
        'name' => 'nullable|string|max:255',
        'date' => 'date',
        'notes' => 'nullable|string|max:255',
		'order_billing_type_id' => 'integer:exists:order_billing_types,id',
        'approval_date' => 'nullable|date',
        'completion_date' => 'nullable|date',
        'expiration_date' => 'nullable|date',
        'order_category_id' => 'nullable|integer:exists:order_categories,id',
        'order_priority_id' => 'nullable|integer:exists:order_priorities,id',
        'order_type_id' => 'nullable|integer:exists:order_types,id',
        'order_status_id' => 'nullable|integer:exists:order_statuses,id',
        'order_action_id' => 'nullable|integer:exists:order_actions,id',
        'start_date' => 'nullable|date',
        'recurrences' => 'nullable|integer',
        'service_window' => 'nullable|integer',
        'indefinite' => 'boolean',
        'location' => 'nullable|string|max:255',
        'instructions' => 'nullable|string|max:255',
        'notes' => 'nullable|string|max:255',
        'purchase_order_number' => 'nullable|string|max:255',
        'budget' => 'nullable|string|max:255',
        'budget_plus_minus' => 'nullable|integer|max:255',
        'budget_invoice_number' => 'nullable|string|max:255',
        'bid' => 'nullable|string|max:255',
        'bid_plus_minus' => 'nullable|integer|max:255',
        'invoice_number' => 'nullable|string|max:255',
        'renewable' => 'boolean',
        'frequency' => 'nullable|max:255',
        'renewal_date' => 'nullable|date',
        'notification_lead' => 'nullable|max:255',
        'renewal_message' => 'nullable|string|max:255',
        'order_interval' => 'nullable|string|max:255',
        'renewal_interval' => 'nullable|string|max:255'
    ];
    
    public function __construct()
    {
        //
    }

    public function index(Request $request){
        $this->validate($request, $this->validation);
        $values = $request->only(array_keys($this->validation));
        $items_query = Order::with('project', 'project.contact', 'project.client', 'properties')
        ->orderBy('date');
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $completed = $request->input('completed');
        if($completed == 'false'){
            
            $items_query->whereNull('completion_date');
        }
        
        $expired = $request->input('expired');
        if($completed == 'false'){
            $items_query->where(function ($q) {
                $q->where('expiration_date','>=',date('Y-m-d'))
                ->orWhereNull('expiration_date');
            });
        }
        
        return $items_query->get();
    }
    
    public function create(Request $request){
        $this->validate($request, $this->validation);
        $values = $request->only(array_keys($this->validation));
        $values = $request->input();
        $values['creator_id'] = $request->user()->id;
        $values['updater_id'] = $request->user()->id;
        $item = Order::create($values);
        $item = Order::findOrFail($item->id);
        $properties = $request->only('properties');
        $item->properties()->sync($properties['properties']);
        return $item;
    }
    
    public function read($id){
        $item = Order::with(
            'project',
            'project.contact',
            'project.contact.phoneNumbers',
            'project.contact.phoneNumbers.phoneNumberType',
            'project.client',
            'properties',
            'properties.contacts',
            'properties.contacts.phoneNumbers',
            'properties.contacts.phoneNumbers.phoneNumberType',
            'approver',
            'tasks',
            'tasks.taskCategory',
            'tasks.taskStatus',
            'tasks.taskAppointmentStatus',
            'tasks.taskAction',
            'tasks.taskType',
            'orderPriority',
            'orderCategory'
        )
        ->where('id', $id)
        ->first();
        if(empty($item)){
            return response([], 404);
        }
        return $item;
    }
    
    public function update($id, Request $request){
        error_log(print_r($request->all(),true));
        $this->validate($request, $this->validation);     
        $item = Order::findOrFail($id);
        $values = $request->only(array_keys($this->validation));
        error_log(print_r($values, true));
        $values['updater_id'] = $request->user()->id;
        $item->update($values);
        $properties = $request->only('properties');
        $item->properties()->sync($properties['properties']);
        return $item;
    }
    
    public function delete($id){
        $item = Order::findOrFail($id);
        $item->delete();
        return response([], 204);
    }    

}
