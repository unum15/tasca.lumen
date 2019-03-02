<?php

namespace App\Http\Controllers;

use App\TaskDate;
use Illuminate\Http\Request;

class TaskDateController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    private $validation = [
        'task_id' => 'integer:exists:tasks,id',
        'day' => 'nullable|string|max:255',
        'date' => 'nullable|date',
        'time' => 'nullable|string|max:255',
        'notes' => 'nullable|string|max:255',
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){
        $this->validate($request, $this->validation);
        $values = $request->only(array_keys($this->validation));
        $items_query = TaskDate::with(
            'task',
            'task.order',
            'task.order.project',
            'task.order.properties',
            'task.order.project.contact',
            'task.order.project.client',
            'task.TaskCategory',
            'task.TaskStatus',
            'task.TaskAppointmentStatus',
            'task.TaskAction',
            'task.order.orderPriority',
            'task.order.orderCategory'
        )
        ->orderBy('id');
       foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $active_only = $request->only('active_only');
        if((!empty($active_only)) && ($active_only['active_only'] == 'true')){
            $items_query->whereHas(
                'task.order' , function($q){
                    $q->whereNull('completion_date');
                    $q->whereNull('expiration_date');
                    $q->whereNotNull('approval_date');
                }
            );
        }
        $min_date = $request->only('min_date');
        if(!empty($min_date)){
            $items_query->where('date', '<=', $min_date['min_date']);
        }
        return $items_query->get();
    }
    
    public function create(Request $request){
        $this->validate($request, $this->validation);
        $values = $request->only(array_keys($this->validation));
        $values['creator_id'] = $request->user()->id;
        $values['updater_id'] = $request->user()->id;
        $item = TaskDate::create($values);
        $item = TaskDate::findOrFail($item->id);
        return $item;
    }
    
    public function read($id){
        $item = TaskDate::with(
            'task',
            'task.order',
            'task.order.project',
            'task.order.properties',
            'task.order.project.contact',
            'task.order.project.contact.phoneNumbers',
            'task.order.project.contact.phoneNumbers.phoneNumberType',
            'task.order.project.client',
            'task.order.properties.contacts',
            'task.order.properties.contacts.phoneNumbers',
            'task.order.properties.contacts.phoneNumbers.phoneNumberType',
            'task.TaskCategory',
            'task.TaskStatus',
            'task.TaskAppointmentStatus',
            'task.TaskAction',
            'task.order.orderPriority',
            'task.order.orderCategory'
        )
        ->findOrFail($id);
        return $item;
    }
    
    public function update($id, Request $request){
        $this->validate($request, $this->validation);     
        $item = TaskDate::findOrFail($id);
        $values = $request->only(array_keys($this->validation));
        $values['updater_id'] = $request->user()->id;
        $item->update($values);
        return $item;
    }
    
    public function delete($id){
        $item = TaskDate::findOrFail($id);
        $item->delete();
        return response([], 204);
    }    

}
