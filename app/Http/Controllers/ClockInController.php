<?php

namespace App\Http\Controllers;

use App\ClockIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClockInController extends Controller
{
    private $validation = [
        'appointment_id' => 'integer|exists:appointments,id',
        'contact_id' => 'integer|exists:contacts,id',
        'labor_activity_id' => 'integer|exists:labor_activities,id|nullable',
        'clock_in' => 'string|max:255',
        'clock_out' => 'string|max:255',
        'notes' => 'nullable|string|max:255'
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->validate($request, $this->validation);
        $values = $request->only(array_keys($this->validation));
        $items_query = ClockIn::with(
            'appointment',
            'appointment.Task',
            'appointment.Task.Order',
            'labor_activity',
            'Contact',
            'appointment.Task.Order.Project',
            'appointment.Task.Order.Project.Client'
        )
        ->orderBy('clock_in');
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $task_id = $request->input('task_id');
        if(!empty($task_id)) {
            $items_query->whereHas(
                'appointment', function ($q) use ($task_id) {
                    $q->where('appointments.task_id', $task_id);
                }
            );
        }
        $order_id = $request->input('order_id');
        if(!empty($order_id)) {
            $items_query->whereHas(
                'appointment.Task', function ($q) use ($order_id) {
                    $q->where('tasks.order_id', $order_id);
                }
            );
        }
        $start_date = $request->input('start_date');
        if(!empty($start_date)) {
            $items_query->where(DB::raw('clock_in::DATE'), '>=', $start_date);
        }
        $stop_date = $request->input('stop_date');
        if(!empty($stop_date)) {
            $items_query->where(DB::raw('clock_out::DATE'), '<=', $stop_date);
        }

        return $items_query->get();
    }
    
    public function by_employee(Request $request)
    {
        $validation = [
            'appointment_id' => 'integer|exists:appointments,id',
            'task_id' => 'integer|exists:tasks,id',
            'order_id' => 'integer|exists:orders,id',
            'project_id' => 'integer|exists:projects,id',
        ];
        $this->validate($request, $validation);
        $values = $request->only(array_keys($validation));
        $items_query = DB::table('clock_ins')
            ->leftJoin('appointments', 'clock_ins.appointment_id', '=', 'appointments.id')
            ->leftJoin('tasks', 'appointments.task_id', '=', 'tasks.id')
            ->leftJoin('orders', 'tasks.order_id', '=', 'orders.id')
            ->leftJoin('contacts', 'clock_ins.contact_id', '=', 'contacts.id')
            ->select(
                DB::raw('ROUND((EXTRACT(EPOCH FROM SUM(clock_out-clock_in))/3600)::NUMERIC, 2) AS hours'),
                'contacts.id',
                'contacts.name',
                DB::raw('10.00 AS rate')
            )
            ->groupBy('contacts.id', 'contacts.name')
            ->orderBy('contacts.name');
            ;
        if(!empty($values['task_id'])) {
             $items_query->where('appointments.task_id', $values['task_id']);
        }
        if(!empty($values['order_id'])) {
             $items_query->where('tasks.order_id', $values['order_id']);
        }
        return $items_query->get();
    }

    public function create(Request $request)
    {
        $this->validate($request, $this->validation);
        $this->validate($request, ['clock_in' => 'required', 'appointment_id' => 'required']);
        $values = $request->only(array_keys($this->validation));
        $values = $request->input();
        $values['creator_id'] = $request->user()->id;
        $values['updater_id'] = $request->user()->id;
        $item = ClockIn::create($values);
        $item = ClockIn::with(
            'appointment',
            'appointment.task',
            'appointment.task.order',
            'appointment.task.labor_assignment',
            'labor_activity',
            'contact'
        )
        ->findOrFail($item->id);
        return response(['data' => $item], 201, ['Location' => route('clock_in.read', ['id' => $item->id])]);
    }
    
    public function read($id)
    {
        $item = ClockIn::with(
            'appointment',
            'appointment.task',
            'appointment.task.order',
            'appointment.task.labor_assignment',
            'labor_activity',
            'contact'
        )
        ->findOrFail($id);
        return $item;
    }

    
    public function current(Request $request)
    {
        $item = ClockIn::with([
            'appointment',
            'appointment.task',
            'appointment.task.order',
            'appointment.task.labor_assignment',
            'labor_activity',
            'contact'
        ])
        ->where('contact_id', $request->user()->id)
        ->whereNull('clock_out')
        ->whereRaw('clock_in::DATE=NOW()::DATE')
        ->orderByDesc('clock_in')
        ->first();
        return $item;
    }

    public function update($id, Request $request)
    {
        $this->validate($request, $this->validation);     
        $item = ClockIn::findOrFail($id);
        $values = $request->only(array_keys($this->validation));
        $values['updater_id'] = $request->user()->id;
        $item->update($values);
        $item = ClockIn::with(
            'appointment',
            'appointment.Task',
            'labor_activity',
            'Contact'
        )
        ->findOrFail($id);
        return $item;
    }

    public function delete($id)
    {
        $item = ClockIn::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
}