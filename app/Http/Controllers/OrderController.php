<?php

namespace App\Http\Controllers;

use App\Order;
use App\Property;
use App\Task;
use App\TaskDate;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    private $validation = [
        'description' => 'string|min:1|max:1024',
        'project_id' => 'integer|exists:projects,id',
        'order_status_type_id' => 'integer|exists:order_status_types,id',
        'name' => 'nullable|string|max:255',
        'date' => 'date',
        'notes' => 'nullable|string|max:255',
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
        'recurring' => 'boolean',
        'location' => 'nullable|string|max:1024',
        'instructions' => 'nullable|string|max:1024',
        'notes' => 'nullable|string|max:1024',
        'purchase_order_number' => 'nullable|string|max:255',
        'budget' => 'nullable|string|max:255',
        'budget_plus_minus' => 'nullable|integer',
        'budget_invoice_number' => 'nullable|string|max:255',
        'bid' => 'nullable|string|max:255',
        'bid_plus_minus' => 'nullable|integer',
        'invoice_number' => 'nullable|string|max:255',
        'renewable' => 'boolean',
        'frequency' => 'nullable|max:255',
        'renewal_date' => 'nullable|date',
        'notification_lead' => 'nullable|max:255',
        'renewal_message' => 'nullable|string|max:255',
        'recurring_interval' => 'nullable|string|max:255',
        'renewal_interval' => 'nullable|string|max:255'
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->validate($request, $this->validation);
        $values = $request->only(array_keys($this->validation));
        $items_query = Order::with('project', 'project.contact', 'project.client', 'properties', 'tasks', 'tasks.dates', 'tasks.dates.clockIns')
        ->orderBy('date');
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $completed = $request->input('completed');
        if($completed == 'false') {
            
            $items_query->whereNull('completion_date');
        }
        
        $expired = $request->input('expired');
        if($completed == 'false') {
            $items_query->where(
                function ($q) {
                    $q->where('expiration_date', '>=', date('Y-m-d'))
                        ->orWhereNull('expiration_date');
                }
            );
        }
        
        $status = $request->input('status');
        if(!empty($status)) {
            $items_query->whereNotNull('orders.approval_date')
                        ->whereNotNull('orders.start_date')
                        ->where(function ($q){
                            $date = date_create();
                            $date->modify('-14 days');
                            $q->where('completion_date', '>=', $date->format('Y-m-d'))
                            ->orWhereNull('completion_date');
                        });
            switch ($status) {
                case 'Completed' :
                    $items_query
                    ->whereDoesntHave('tasks', function($q){
                        $q->whereNull('completion_date');
                    })
                    ->whereHas('tasks', function($q){
                        $q->whereNotNull('completion_date');
                        $q->where(function ($q){
                            $date = date_create();
                            $date->modify('-14 days');
                            $q->where('closed_date', '>=', $date->format('Y-m-d'))
                            ->orWhereNull('closed_date');
                        });
                    });
                    break;
                case 'Non-Completed' :
                    $items_query->whereHas('tasks', function($query){
                        $query->whereNull('completion_date');
                    })
                    ->whereHas('tasks', function($q){
                        $q->whereNotNull('completion_date');
                    });
                    break;
            }
            
        }
        $items = $items_query->get();
        return $items;
    }
    
    public function create(Request $request)
    {
        $this->validate($request, $this->validation);
        $this->validate($request, ['name' => 'required', 'project_id' => 'required']);
        $values = $request->only(array_keys($this->validation));
        $values = $request->input();
        $values['approval_date'] = isset($values['approval_date']) && $values['approval_date'] != "" ? $values['approval_date'] : null;
        $values['start_date'] = isset($values['start_date']) && $values['start_date'] != "" ? $values['start_date'] : null;
        $values['completion_date'] = isset($values['completion_date']) && $values['completion_date'] != "" ? $values['completion_date'] : null;
        $values['expiration_date'] = isset($values['expiration_date']) && $values['expiration_date'] != "" ? $values['expiration_date'] : null;
        $values['renewal_date'] = isset($values['renewal_date']) && $values['renewal_date'] != "" ? $values['renewal_date'] : null;
        $values['creator_id'] = $request->user()->id;
        $values['updater_id'] = $request->user()->id;
        if(empty($values['order_status_type_id'])) {
            $values['order_status_type_id'] = $this->orderStatusType($values['start_date']);
        }
        $item = Order::create($values);
        $item = Order::findOrFail($item->id);
        $this->syncProperties($item, $request);
        return $item;
    }
    
    
    public function read($id)
    {
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
            'tasks.taskAction',
            'tasks.taskType',
            'orderPriority',
            'orderCategory',
            'tasks.dates.clockIns',
            'tasks.dates.clockIns.contact'
        )
            ->where('id', $id)
            ->first();
        if(empty($item)) {
            return response([], 404);
        }
        return $item;
    }
    
    public function update($id, Request $request)
    {
        $this->validate($request, $this->validation);     
        $item = Order::findOrFail($id);
        $values = $request->only(array_keys($this->validation));
        $values = $request->input();
        $values['approval_date'] = isset($values['approval_date']) && $values['approval_date'] != "" ? $values['approval_date'] : null;
        $values['start_date'] = isset($values['start_date']) && $values['start_date'] != "" ? $values['start_date'] : null;
        $values['completion_date'] = isset($values['completion_date']) && $values['completion_date'] != "" ? $values['completion_date'] : null;
        $values['expiration_date'] = isset($values['expiration_date']) && $values['expiration_date'] != "" ? $values['expiration_date'] : null;
        $values['renewal_date'] = isset($values['renewal_date']) && $values['renewal_date'] != "" ? $values['renewal_date'] : null;
        $values['updater_id'] = $request->user()->id;
        if(($item->order_status_type_id != 1) || ($values['order_status_type_id'] == 1)){
            $item->update($values);
            $this->syncProperties($item, $request);
        }
        else{
            $properties = $request->only('properties');
            $properties = $properties['properties'];
            if(count($properties) == 1){
                $item->update($values);
                $this->syncProperties($item, $request);
            }
            else{
                $items = [];
                $property = array_shift($properties);
                $pname = Property::find($property)->name;
                $oname = $values['name'];
                $odescription = $values['description'];
                $values['name'] = $oname . '-' . $pname;
                $values['description'] = $odescription . '-' . $pname;
                $item->update($values);
                $item->properties()->sync([$property]);
                array_push($items, $item);
                $values['creator_id'] = $request->user()->id;
                $values['updater_id'] = $request->user()->id;
                foreach($properties as $property){
                    $pname = Property::find($property)->name;
                    $values['name'] = $oname . '-' . $pname;
                    $values['description'] = $odescription . '-' . $pname;
                    $new_item = Order::create($values);
                    $new_item->properties()->attach($property);
                    foreach($item->tasks as $task){
                        $task_values = $task->toArray();
                        unset($task_values['id']);
                        $task_values['order_id'] = $new_item->id;
                        $new_task = Task::create($task_values);
                        foreach($task->dates as $date){
                            $date_values = $date->toArray();
                            unset($date_values['id']);
                            $date_values['task_id'] = $new_task->id;
                            TaskDate::create($date_values);
                        }
                    }
                    array_push($items, $new_item);
                }
                return $items;
            }
        }
        return $item;
    }
    
    public function syncProperties($item, $request)
    {
        if($item->order_status_type_id == 1) {
            $properties = $request->only('properties');
            if(!empty($properties)) {
                $properties = $properties['properties'];
            }
            else{
                $properties = [];
            }
        }
        else{
            $property = $request->only('property');
            if(!empty($property)) {
                $properties = [$property['property']];
            }
            else{
                $properties = [];
            }
        }
        $properties = array_filter($properties);
        $item->properties()->sync($properties);
    }
    
    public function delete($id)
    {
        $item = Order::findOrFail($id);
        $item->delete();
        return response([], 204);
    }    

    public function convert($id, Request $request)
    {
        $this->validate($request, $this->validation);
        $values = $request->only(array_keys($this->validation));
        $values = $request->input();//need to take this out
        $new_values = $values;
        $new_values['creator_id'] = $request->user()->id;
        $new_values['updater_id'] = $request->user()->id;
        $new_values['recurring'] = false;
        $new_values['renewable'] = false;
        unset($new_values['id']);
        unset($new_values['completion_date']);
        $items = [];
        $properties = $request->only('properties');
        if(isset($properties['properties'])){
            $properties = $properties['properties'];
        }

        $original_order = Order::findOrFail($id);
        //add number as per Paul
        $order_number = 1;
        $recurring = ((!empty($values['recurring']))&&($values['recurring'] == 'true'));
        if(($recurring)||((!empty($values['renewable']))&&($values['renewable'] == 'true'))) {
            $start_date = date_create($values['start_date']);
            $count = $recurring ? $values['recurrences'] : 1;
            for($item_number = 0; $item_number < $count; $item_number++){    
                $new_values['start_date'] = $start_date->format('Y-m-d');
                $new_values['order_status_type_id'] = $this->orderStatusType($new_values['start_date']);
                foreach($properties as $property){
                    $append = $recurring ? ' ' . $order_number++ : null;
                    $new_values['name'] = $values['name'] . $append;
                    $append = $recurring ? ' ' .  $start_date->format('Y-m-d') : null;
                    $new_values['description'] = $values['description'] . $append;
                    $item = Order::create($new_values);
                    $item->properties()->attach($property);
                    foreach($original_order->tasks as $task){
                        $task_values = $task->toArray();
                        unset($task_values['id']);
                        $task_values['order_id'] = $item->id;
                        Task::create($task_values);
                    }
                    array_push($items, Order::findOrFail($item->id));
                }
                if($recurring) {
                    $start_date->modify('+'.$values['recurring_interval']);
                }
            }
        }
        if(!empty($values['renewable']) && ($values['renewable'] == 'true')) {
            $date = date_create($values['renewal_date']);
            $date->modify('+'.$values['renewal_interval']);
            $original_order->update(
                [
                'renewal_date' => $date->format('Y-m-d'),
                'renewal_count' => $original_order->renewal_count - 1,
                'approval_date' => null,
                'start_date' => null,
                'service_window' => $request->user()->default_service_window
                ]
            );
            array_push($items, Order::findOrFail($original_order->id));
        }
        else{
            $original_order->update(['completion_date' => date('Y-m-d')]);
            array_push($items, Order::findOrFail($original_order->id));
        }
        return $items;
    }
    
    public function orderStatusType($date)
    {
        if(empty($date)) {
            return 1;
        }
        $today = date_create();
        $window = Auth::user()->default_service_window;
        $date_obj = date_create($date);
        if($today->diff($date_obj)->days <= $window) {
            return 3;
        }
        else{
            return 2;
        }
    }
    
    public function closable()
    {
        $items_query = Order::with('project', 'project.contact', 'project.client', 'properties', 'tasks', 'tasks.dates', 'tasks.dates.clockIns')
        ->orderBy('date');
        $items_query->whereNull('completion_date')
        ->where(function ($query) {
            $date = date_create();
            $query->whereNull('expiration_date')
            ->orWhere('completion_date', '>=', $date->format('Y-m-d'));
        })
        ->whereDoesntHave('tasks', function($q){
            $q->whereNull('completion_date');
        })
        ->has('tasks')
        ;
        $items = $items_query->get();
        return $items;
    }
}
