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
        'sort_order' => 'nullable|string|max:255',
        'time' => 'nullable|string|max:255',
        'notes' => 'nullable|string|max:255',
        'appointment_status_id' => 'nullable|integer:exists:appointment_statuses,id'        
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
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
            'task.TaskAction',
            'task.order.orderPriority',
            'task.order.orderCategory'
        )
        ->orderBy('id');
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $active_only = $request->only('active_only');
        if((!empty($active_only)) && ($active_only['active_only'] == 'true')) {
            $items_query->whereHas(
                'task.order', function ($q) {
                    $q->whereNull('completion_date');
                    $q->whereNull('expiration_date');
                    $q->whereNotNull('approval_date');
                }
            );
        }
        $min_date = $request->only('min_date');
        if(!empty($min_date)) {
            $items_query->where(
                function ($q) use ($min_date) {
                    $q->whereNull('date')
                        ->orWhere('date', '>=', $min_date['min_date']);
                
                }
            );
        }
        $order_id = $request->input('order_id');
        if(!empty($order_id)) {
            $items_query->whereHas(
                'Task', function ($q) use ($order_id) {
                    $q->where('tasks.order_id', $order_id);
                }
            );
        }
        return $items_query->get();
    }
    
    
    public function schedule(Request $request)
    {
        $this->validate($request, $this->validation);
        $date = $request->input('date', date('Y-m-d'));
        $items_query = DB::table('tasks')
            ->leftJoin('task_dates', 'tasks.id', '=', 'task_dates.task_id')
            ->leftJoin('orders', 'tasks.order_id', '=', 'orders.id')
            ->leftJoin('projects', 'orders.project_id', '=', 'projects.id')
            ->leftJoin('order_property', 'orders.id', '=', 'order_property.order_id')
            ->leftJoin('properties', 'order_property.property_id', '=', 'properties.id')
            ->leftJoin('contacts', 'projects.contact_id', '=', 'contacts.id')
            ->leftJoin('clients', 'projects.client_id', '=', 'clients.id')
            ->leftJoin('appointment_statuses', 'task_dates.appointment_status_id', '=', 'appointment_statuses.id')
            ->leftJoin('order_priorities', 'orders.order_priority_id', '=', 'order_priorities.id')
            ->leftJoin('task_categories', 'tasks.task_category_id', '=', 'task_categories.id')
            ->leftJoin('task_statuses', 'tasks.task_status_id', '=', 'task_statuses.id')
            ->leftJoin('task_actions', 'tasks.task_action_id', '=', 'task_actions.id')
            ->leftJoin('crews', 'tasks.crew_id', '=', 'crews.id')
            ->select(
                'task_dates.id',
                DB::raw('row_number() OVER () AS row'),
                'tasks.id AS task_id',
                'orders.start_date',
                'orders.service_window',
                'tasks.name',
                'orders.name AS order_name',
                'orders.description AS order_description',
                'orders.date AS order_date',
                'orders.approval_date',
                'orders.expiration_date',
                'orders.completion_date',
                'orders.project_id',
                'projects.client_id',
                'tasks.order_id',
                'appointment_statuses.name AS appointment_status',
                'appointment_status_id',
                'clients.name AS client',
                'properties.name AS property',
                DB::raw("COALESCE(properties.address1,'')||' '||COALESCE(properties.address2,'')||' - '||COALESCE(properties.city,'') AS address"),
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
                'task_dates.sort_order',
                'task_dates.time',
                'task_dates.notes',
                'tasks.completion_date',
                'tasks.billed_date',
                'tasks.task_type_id',
                'orders.order_status_type_id',
                'tasks.crew_hours',
                'crew_id',
                'crews.name AS crew'
            )

            ;
            $items_query->whereNull('orders.completion_date');
            $items_query->whereNull('tasks.closed_date');
            $items_query->where(
                function ($q) {
                    $q->whereNull('orders.expiration_date')
                        ->orWhere('orders.expiration_date', '>=', date('Y-m-d'));
                }
            );
            $status = strtolower($request->input('status'));
            
        if((!empty($status) && $status!='all')) {
            $date_obj = date_create($date);
            $days = 7; //$request->user()->pending_days_out;
            $current_date = $date_obj->modify('+' . $days . 'days')->format('Y-m-d');
            switch($status){
            case 'current':
                $items_query->where(
                    function ($q) use ($date) {
                        $date_obj = date_create($date);
                        $days = 14;
                        $two_weeks_out = $date_obj->modify('+' . $days . 'days')->format('Y-m-d');
                        $q->whereNull('tasks.hold_date')
                        ->orWhere('tasks.hold_date', '<=', $two_weeks_out);
                    }
                );
                $items_query->where(
                    function ($q) use ($current_date) {
                            $q->where('orders.start_date', '<=', $current_date)
                                ->orWhere('tasks.task_type_id', 1);
                    }
                );
                $items_query->where(
                    function ($q) use ($date) {
                            $q->where('task_dates.date', '>=', $date)
                                ->orWhereNull('task_dates.date');
                    }
                );
                break;
            case 'service':
                $items_query->where(
                    function ($q) {
                            $q->whereNotNull('orders.date')
                                ->whereNull('orders.start_date')
                                ->whereNull('orders.completion_date')
                                ->whereNull('orders.expiration_date')
                                ->where('recurring', false)
                                ->where('renewable', false);
                    }
                );
                break;
            case 'pending':
                $items_query->where('orders.start_date', '>', $current_date);
                $items_query->orderBy('orders.start_date');
                break;
            case 'on hold':
                $date_obj = date_create($date);
                $days = 30;
                $one_month_ago = $date_obj->modify('-' . $days . 'days')->format('Y-m-d');
                $items_query->where('tasks.hold_date', '>=', $one_month_ago);
                break;
            case 'today':
                $items_query->where('task_dates.date', '=', $date);
                break;
            }

        }
        $items_query->orderBy('task_dates.id');
        return $items_query->get();
    }
    
    public function create(Request $request)
    {
        $this->validate($request, $this->validation);
        $values = $request->only(array_keys($this->validation));
        $has_value = false;
        $not_empty = ['date', 'day', 'time', 'notes'];
        foreach($not_empty as $field){
            if(!empty($values[$field])) {
                $has_value = true;
            }
        }
        if(!$has_value) {
            return;//quitely return
        }
        $dates = ['date', 'completion_date', 'billed_date'];
        foreach($dates as $date){
            if(isset($values[$date])) {
                $values[$date] = $values[$date] != "" ? $values[$date] : null;
            }
        }
        $values['creator_id'] = $request->user()->id;
        $values['updater_id'] = $request->user()->id;
        $item = TaskDate::create($values);
        $item = TaskDate::findOrFail($item->id);
        return $item;
    }
    
    public function read($id)
    {
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
            'task.TaskAction',
            'task.order.orderPriority',
            'task.order.orderCategory'
        )
        ->findOrFail($id);
        return $item;
    }
    
    public function update($id, Request $request)
    {
        $this->validate($request, $this->validation);     
        $item = TaskDate::findOrFail($id);
        $values = $request->only(array_keys($this->validation));
        //should be a better way to set blank to null
        $dates = ['date', 'completion_date', 'billed_date', 'time'];
        foreach($dates as $date){
            if(isset($values[$date])) {
                $values[$date] = empty($values[$date]) ? null : $values[$date];
            }
        }
        
        $values['updater_id'] = $request->user()->id;
        $item->update($values);
        return $item;
    }
    
    public function delete($id)
    {
        $item = TaskDate::findOrFail($id);
        $item->delete();
        return response([], 204);
    }    

}
