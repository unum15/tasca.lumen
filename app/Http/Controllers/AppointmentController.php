<?php

namespace App\Http\Controllers;

use App\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    
    private $validation = [
        'task_id' => 'integer:exists:tasks,id',
        'day' => 'nullable|string|max:255',
        'date' => 'nullable|date',
        'sort_order' => 'nullable|string|max:255',
        'time' => 'nullable|string|max:255',
        'hours' => 'nullable|string|max:255',
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
        $items_query = Appointment::with(
            'task',
            'task.order',
            'task.order.project',
            'task.order.properties',
            'task.order.project.contact',
            'task.order.project.client',
            'task.labor_assignment',
            'task.labor_type',
            'task.task_status',
            'task.task_action',
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
                    $q->whereNull('close_date');
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
        $crew_id = $request->input('crew_id');
        $items_query = DB::table('tasks')
            ->leftJoin('appointments', 'tasks.id', '=', 'appointments.task_id')
            ->leftJoin('orders', 'tasks.order_id', '=', 'orders.id')
            ->leftJoin('projects', 'orders.project_id', '=', 'projects.id')
            ->leftJoin('order_property', 'orders.id', '=', 'order_property.order_id')
            ->leftJoin('properties', 'order_property.property_id', '=', 'properties.id')
            ->leftJoin('contacts', 'projects.contact_id', '=', 'contacts.id')
            ->leftJoin('clients', 'projects.client_id', '=', 'clients.id')
            ->leftJoin('appointment_statuses', 'appointments.appointment_status_id', '=', 'appointment_statuses.id')
            ->leftJoin('order_priorities', 'orders.order_priority_id', '=', 'order_priorities.id')
            ->leftJoin('task_categories', 'tasks.task_category_id', '=', 'task_categories.id')
            ->leftJoin('task_statuses', 'tasks.task_status_id', '=', 'task_statuses.id')
            ->leftJoin('task_actions', 'tasks.task_action_id', '=', 'task_actions.id')
            ->leftJoin('crews', 'tasks.crew_id', '=', 'crews.id')
            ->select(
                'appointments.id',
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
                'orders.close_date AS order_close_date',
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
                'appointments.day',
                'appointments.date',
                'appointments.sort_order',
                'appointments.time',
                'appointments.notes',
                'tasks.completion_date',
                'tasks.closed_date',
                'tasks.billed_date',
                'tasks.task_type_id',
                'orders.order_status_type_id',
                'tasks.crew_hours',
                'crew_id',
                'crews.name AS crew'
        );
        if(!empty($crew_id)){
            switch($crew_id){
                case '*':
                    break;
                case '':
                    $items_query->whereNull('crew_id');
                    break;
                default:
                    $items_query->where('crew_id',$crew_id);
            }
        }
        $status = strtolower($request->input('status'));
        $items_query->whereNull('projects.close_date');
        
        if(!empty($status)) {
            $date_obj = date_create($date);
            $current_view_days = $request->input('view_days',14);
            $current_view_date = $date_obj->modify('+' . $current_view_days . 'days')->format('Y-m-d');
            switch($status){
                case 'service':
                    $items_query->whereNull('orders.close_date')
                    ->where(
                        function ($q) {
                            $q->whereNull('orders.expiration_date')
                                ->orWhere('orders.expiration_date', '>=', date('Y-m-d'));
                        }
                    )
                    ->where(
                        function ($q) use ($date){
                            $q->where('appointments.date', '>=', $date)
                            ->orWhereNull('appointments.date');
                        }
                    )
                    ->where(
                        function ($q){
                            $q->whereNull('tasks.completion_date')
                            ->orWhereNull('tasks.closed_date');
                        }
                    )
                    ->where('recurring', false)
                    ->where('renewable', false)
                    ->whereNull('orders.start_date')
                    ->WhereNull('orders.approval_date');
                    break;
                            //On Hold, All Task, Pending Task, Current Task tab
            //Start Date and (Blank Close, or expiration date), and the Tasks that have a (blank completion or closed date).
            //Show blank and future task dates from the date on the calendar on the page.


                case 'current':
                    $items_query->whereNotNull('orders.start_date')
                    ->whereNull('orders.close_date')
                    ->whereNull('tasks.completion_date')
                    ->WhereNull('tasks.closed_date')
                    ->where(
                        function ($q) use ($date) {
                            $q->whereNull('orders.expiration_date')
                            ->orWhere('orders.expiration_date','>=',$date);
                        }
                    );
                    $items_query->where(
                        function ($q) use ($current_view_date) {
                            $q->where('orders.start_date', '<=', $current_view_date)
                            ->orWhereNotNull('appointments.date');
                        }
                    );
                    $items_query->where(
                        function ($q) use ($date) {
                                $q->where('appointments.date', '>=', $date)
                                ->orWhereNull('appointments.date');
                        }
                    );
                    break;
                case 'pending':
                    $items_query->where('orders.start_date','>=',$current_view_date)
                    ->whereNull('orders.completion_date')
                    ->whereNull('tasks.completion_date')
                    ->WhereNull('tasks.closed_date')
                    ->where(
                        function ($q) use ($date) {
                            $q->whereNull('orders.expiration_date')
                            ->orWhere('orders.expiration_date','>=',$date);
                        }
                    )
                    ->where(
                        function ($q) use ($date){
                            $q->where('appointments.date', '>=', $date)
                            ->orWhereNull('appointments.date');
                        }
                    );
                    $items_query->orderBy('orders.start_date');
                    break;
                case 'on hold':
                    $items_query->whereNotNull('orders.start_date')
                    ->whereNull('orders.completion_date')
                    ->whereNull('tasks.completion_date')
                    ->WhereNull('tasks.closed_date')
                    ->where(
                        function ($q) use ($date) {
                            $q->whereNull('orders.expiration_date')
                            ->orWhere('orders.expiration_date','>=',$date);
                        }
                    )
                    ->where(
                        function ($q) use ($date){
                            $q->where('appointments.date', '>=', $date)
                            ->orWhereNull('appointments.date');
                        }
                    );
                    
                    $items_query->where('tasks.hold_date', '>=', $date);
                    $items_query->orderBy('orders.start_date');
                    break;
                case 'today':
                    $items_query->where('appointments.date', '=', $date);
                    break;
                case 'all' :
                    $items_query->whereNotNull('orders.start_date')
                    ->whereNull('orders.completion_date')
                    ->whereNull('tasks.completion_date')
                    ->WhereNull('tasks.closed_date')
                    ->where(
                        function ($q) use ($date) {
                            $q->whereNull('orders.expiration_date')
                            ->orWhere('orders.expiration_date','>=',$date);
                        }
                    )
                    ->where(
                        function ($q) use ($date){
                            $q->where('appointments.date', '>=', $date)
                            ->orWhereNull('appointments.date');
                        }
                    );
                    $items_query->orderBy('orders.start_date');

            }
            
        }
        $items_query->orderBy('appointments.id');
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
            return;
        }
        $dates = ['date', 'completion_date', 'billed_date'];
        foreach($dates as $date){
            if(isset($values[$date])) {
                $values[$date] = $values[$date] != "" ? $values[$date] : null;
            }
        }
        $values['creator_id'] = $request->user()->id;
        $values['updater_id'] = $request->user()->id;
        $item = Appointment::create($values);

        return response(['data' => $item], 201, ['Location' => route('appointment.read', ['id' => $item->id])]);
    }
    
    public function read($id)
    {
        $item = Appointment::with(
            'task',
            'task.order',
            'task.order.project',
            'task.order.properties',
            'task.order.project.contact',
            'task.order.project.contact.phoneNumbers',
            'task.order.project.contact.phoneNumbers.phoneNumberType',
            'task.order.project.client',
            'task.order.properties.contacts',
            'task.order.properties.contacts.clientContactTypes',
            'task.order.properties.contacts.clientContactTypes.contact_type',            
            'task.order.properties.contacts.emails',
            'task.order.properties.contacts.emails.emailType',
            'task.order.properties.contacts',
            'task.order.properties.contacts.phoneNumbers',
            'task.order.properties.contacts.phoneNumbers.phoneNumberType',
            'task.labor_assignment',
            'task.task_status',
            'task.task_action',
            'task.order.orderPriority',
            'task.order.orderCategory'
        )
        ->findOrFail($id);
        return $item;
    }
    
    public function update($id, Request $request)
    {
        $this->validate($request, $this->validation);     
        $item = Appointment::findOrFail($id);
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
        $item = Appointment::findOrFail($id);
        $item->delete();
        return response([], 204);
    }

    public function mailAppointment($id){
        $data = $contact->toArray();
        $data['date'] = '2021-01-01';
        $data['time'] = '12:00:00 pm';
        Mail::send('mail.appointment', $data, function($message) use ($contact) {
            $message->to($contact->login, $contact->name)->subject('Scheduled Appointment');
        });
    }

}
