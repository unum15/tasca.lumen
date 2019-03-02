<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    private $validation = [
        'order_id' => 'integer:exists:orders,id',
        'description' => 'nullable|string|max:255',
        'name' => 'nullable|string|max:255',
        'billable' => 'nullable|boolean',
        'task_type_id' => 'nullable|integer:exists:task_types,id',
        'task_status_id' => 'nullable|integer:exists:task_statuses,id',
        'task_appointment_status_id' => 'nullable|integer:exists:task_appointment_statuses,id',
        'task_action_id' => 'nullable|integer:exists:task_actions,id',
        'task_category_id' => 'nullable|integer:exists:task_category,id',
        'completion_date' => 'nullable|date',
        'task_hours' => 'nullable|integer',
        'crew_hours' => 'nullable|integer',
        'notes' => 'nullable|string|max:255',
        'sort_order' => 'nullable|string|max:255',
        'order_id' => 'integer|exists:orders,id',
        'notes' => 'nullable|string|max:1024',
        'group' => 'nullable|string|max:255'
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){
        $this->validate($request, $this->validation);
        $values = $request->only(array_keys($this->validation));
        $items_query = Task::with(
            'order',
            'order.project',
            'order.properties',
            'order.project.contact',
            'order.project.client',
            'TaskCategory',
            'TaskStatus',
            'TaskAppointmentStatus',
            'TaskAction',
            'order.orderPriority',
            'order.orderCategory'
        )
        ->orderBy('id');
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $active_only = $request->only('active_only');
        if((!empty($active_only)) && ($active_only['active_only'] == 'true')){
            $items_query->whereHas(
                'order' , function($q){
                    $q->whereNull('completion_date');
                    $q->whereNull('expiration_date');
                    $q->whereNotNull('approval_date');
                }
            );
        }
        return $items_query->get();
    }
    
    public function create(Request $request){
        $this->validate($request, $this->validation);
        $values = $request->only(array_keys($this->validation));
        $values['creator_id'] = $request->user()->id;
        $values['updater_id'] = $request->user()->id;
        $item = Task::create($values);
        $item = Task::findOrFail($item->id);
        return $item;
    }
    
    public function read($id){
        $item = Task::with(
            'order',
            'order.project',
            'order.properties',
            'order.project.contact',
            'order.project.contact.phoneNumbers',
            'order.project.contact.phoneNumbers.phoneNumberType',
            'order.project.client',
            'order.properties.contacts',
            'order.properties.contacts.phoneNumbers',
            'order.properties.contacts.phoneNumbers.phoneNumberType',
            'TaskCategory',
            'TaskStatus',
            'TaskAppointmentStatus',
            'TaskAction',
            'order.orderPriority',
            'order.orderCategory',
            'dates'
        )
        ->findOrFail($id);
        return $item;
    }
    
    public function update($id, Request $request){
        $this->validate($request, $this->validation);     
        $item = Task::findOrFail($id);
        $values = $request->only(array_keys($this->validation));
	$values['completion_date'] = $values['completion_date'] != "" ? $values['completion_date'] : null;
        $values['updater_id'] = $request->user()->id;
        $item->update($values);
        return $item;
    }
    
    public function delete($id){
        $item = Task::findOrFail($id);
        $item->delete();
        return response([], 204);
    }    

}
