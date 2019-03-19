<?php

namespace App\Http\Controllers;

use App\TaskDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        //$this->middleware('auth');
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
    
    
    public function schedule(Request $request){
        //$this->validate($request, $this->validation);
        //$values = $request->only(array_keys($this->validation));
        $items_query = DB::table('tasks')
            ->leftJoin('task_dates', 'tasks.id', '=', 'task_dates.task_id')
            ->leftJoin('orders', 'tasks.order_id', '=', 'orders.id')
            ->leftJoin('projects', 'orders.project_id', '=', 'projects.id')
            ->leftJoin('order_property', 'orders.id', '=', 'order_property.order_id')
            ->leftJoin('properties', 'order_property.property_id', '=', 'properties.id')
            ->leftJoin('contacts', 'projects.contact_id', '=', 'contacts.id')
            ->leftJoin('clients', 'projects.client_id', '=', 'clients.id')
            ->leftJoin('task_appointment_statuses', 'tasks.task_appointment_status_id', '=', 'task_appointment_statuses.id')
            ->leftJoin('order_priorities', 'orders.order_priority_id', '=', 'order_priorities.id')
            ->leftJoin('task_categories', 'tasks.task_category_id', '=', 'task_categories.id')
            ->leftJoin('task_statuses', 'tasks.task_status_id', '=', 'task_statuses.id')
            ->leftJoin('task_actions', 'tasks.task_action_id', '=', 'task_actions.id')
            ->select('task_dates.id',
                'tasks.id AS task_id',
                'orders.start_date',
                'orders.service_window',
                'tasks.name',
                'orders.approval_date',
                'orders.expiration_date',
                'orders.completion_date',
                'projects.client_id',
                'tasks.order_id',
                'task_appointment_statuses.name AS task_appointment_status',
                'task_appointment_status_id',
                'clients.name AS client',
                'properties.name AS property',
                'tasks.description',
                'order_priorities.name AS order_priority',
                'task_categories.name AS task_category',
                'task_statuses.name AS task_status',
                'task_actions.name AS task_action',
                'order_priority_id',
                'task_category_id',
                'task_status_id',
                'task_action_id',
                'task_dates.day',
                'task_dates.date',
                'tasks.sort_order',
                'task_dates.time',
                DB::raw("CASE WHEN start_date + (service_window || 'days')::INTERVAL < NOW()::DATE THEN 'danger' ELSE null END AS \"_rowVariant\" ")
            )
            ->orderBy('task_dates.id');
            ;
            $items_query->whereNull('orders.completion_date');
            $items_query->whereNull('orders.expiration_date');
            $items_query->whereNotNull('orders.approval_date');
            $order_status_type_id = $request->only('order_status_type_id');
            if(!empty($order_status_type_id['order_status_type_id'])){
                $items_query->where('orders.order_status_type_id', $order_status_type_id['order_status_type_id']);
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
