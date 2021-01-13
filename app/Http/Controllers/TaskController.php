<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    
    private $validation = [
        'order_id' => 'integer|exists:orders,id',
        'description' => 'nullable|string|max:255',
        'name' => 'nullable|string|max:255',
        'billable' => 'nullable|boolean',
        'labor_type_id' => 'nullable|integer|exists:labor_types,id',
        'task_status_id' => 'nullable|integer|exists:task_statuses,id',
        'task_action_id' => 'nullable|integer|exists:task_actions,id',
        'labor_assignment_id' => 'nullable|integer|exists:labor_assignments,id',
        'completion_date' => 'nullable|date',
        'closed_date' => 'nullable|date',
        'invoiced_date' => 'nullable|date',
        'billed_date' => 'nullable|date',
        'hold_date' => 'nullable|date',
        'task_hours' => 'nullable|integer',
        'crew_hours' => 'nullable|numeric',
        'crew_id' => 'nullable|integer|exists:crews,id',
        'notes' => 'nullable|string|max:255',
        'order_id' => 'integer|exists:orders,id',
        'notes' => 'nullable|string|max:1024',
        'group' => 'nullable|string|max:255',
        'hide'  => 'nullable|boolean'
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->validate($request, $this->validation);
        $values = $request->only(array_keys($this->validation));
        $items_query = Task::with(
            'order',
            'order.project',
            'order.properties',
            'order.project.contact',
            'order.project.client',
            'labor_assignment',
            'task_status',
            'task_action',
            'order.orderPriority',
            'order.orderCategory',
            'crew',
            'appointments',
            'appointments.clockIns',
            'appointments.AppointmentStatus'
        )
        ->orderBy('id');

        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $active_only = $request->input('active_only');
        if((!empty($active_only)) && ($active_only == 'true')) {
            $items_query->whereHas(
                'order', function ($q) {
                    $q->whereNull('completion_date');
                    $q->whereNotNull('approval_date');
                    $q->where(
                        function ($q) {
                            $q->where('expiration_date', '>=', date('Y-m-d'))
                                ->orWhereNull('expiration_date');
                        }
                    );
                }
            );
            $items_query->whereNull('completion_date');
        }
        $completed = $request->input('completed');
        if((!empty($completed)) && ($completed == 'true')) {
            $items_query->whereNotNull('completion_date');
        }
        if((!empty($completed)) && ($completed == 'false')) {
            $items_query->whereNull('completion_date');
        }
        $closed = $request->input('closed');
        if((!empty($closed)) && ($closed == 'true')) {
            $items_query->whereNotNull('closed_date');
        }
        if((!empty($closed)) && ($closed == 'false')) {
            $items_query->whereNull('closed_date');
        }
        $min_closed_date = $request->input('min_closed_date');
        if(!empty($min_closed_date)) {
            $items_query->where(
                function ($q) use ($min_closed_date) {
                    $q->where('closed_date', '>=', $min_closed_date)
                        ->orWhereNull('closed_date');
                }
            );
        }
        return $items_query->get();
    }
    
    public function create(Request $request)
    {
        $this->validate($request, $this->validation);
        $this->validate($request, ['name' => 'required']);
        $values = $request->only(array_keys($this->validation));
        $values['creator_id'] = $request->user()->id;
        $values['updater_id'] = $request->user()->id;
        $item = Task::create($values);
        return response(['data' => $item], 201, ['Location' => route('asset.read', ['id' => $item->id])]);
    }
    
    public function read($id)
    {
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
            'order.properties.contacts.emails',
            'order.properties.contacts.emails.emailType',
            'labor_assignment',
            'task_status',
            'task_action',
            'order.orderPriority',
            'order.orderCategory',
            'appointments'
        )
        ->findOrFail($id);
        return $item;
    }
    
    public function update($id, Request $request)
    {
        $this->validate($request, $this->validation);     
        $item = Task::findOrFail($id);
        $values = $request->only(array_keys($this->validation));
        $dates = ['completion_date', 'billed_date', 'closed_date'];
        foreach($dates as $date){
            if(isset($values[$date])) {
                $values[$date] = $values[$date] != "" ? $values[$date] : null;
            }
        }
        $values['updater_id'] = $request->user()->id;
        $item->update($values);
        return $item;
    }
    
    public function delete($id)
    {
        $item = Task::findOrFail($id);
        $item->delete();
        return response([], 204);
    }    

}
