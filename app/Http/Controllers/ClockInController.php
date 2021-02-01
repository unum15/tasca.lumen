<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\ClockIn;
use App\LaborAssignment;
use App\Order;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Log;

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
            'appointment.task',
            'appointment.task.order',
            'appointment.task.labor_assignment',
            'labor_activity',
            'Contact',
            'appointment.task.order.Project',
            'appointment.task.order.Project.Client'
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
        $this->validate($request, ['clock_in' => 'required', 'appointment_id' => 'required', 'contact_id' => 'required']);
        $values = $request->only(array_keys($this->validation));
        $values = $request->input();
        ClockIn::where('contact_id', $values['contact_id'])->whereNull('clock_out')->update(['clock_out' =>  DB::raw('NOW()')]);
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
    
    public function createAssigned(Request $request)
    {
        $validation = [
            'contact_id' => 'integer|exists:contacts,id|required',
            'labor_activity_id' => 'integer|exists:labor_activities,id|nullable|required',
            'labor_assignment_id' => 'integer|exists:labor_assignments,id|nullable|required',
            'clock_in' => 'string|max:255|required',
            'clock_out' => 'string|max:255',
            'notes' => 'nullable|string|max:255'
        ];

        $this->validate($request, $validation);
        $values = $request->only(array_keys($validation));
        $assignment = LaborAssignment::find($values['labor_assignment_id']);
        if(!$assignment->order_id){
            return response(['message' => "No order has been associated with assignment " . $assignment->name], 422);
        }
        ClockIn::where('contact_id', $values['contact_id'])->whereNull('clock_out')->update(['clock_out' =>  DB::raw('NOW()')]);
        $task = $this->getOrCreateAssignedTask($assignment,$request->user()->id,$values['clock_in']);
        $appointment = $this->getOrCreateAssignedAppointment($task,$request->user()->id,$values['clock_in']);
        $values['appointment_id'] = $appointment->id;
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
    
    public function clockOutAssigned($id, Request $request)
    {
        $validation = [
            'labor_activity_id' => 'integer|exists:labor_activities,id|nullable|required',
            'labor_assignment_id' => 'integer|exists:labor_assignments,id|nullable|required',
            'clock_in' => 'string|max:255',
            'clock_out' => 'string|max:255|required',
            'notes' => 'nullable|string|max:255'
        ];
        $this->validate($request, $validation);
        $values = $request->only(array_keys($validation));
        $item = ClockIn::findOrFail($id);
        if($item->appointment->task->labor_assignment_id != $values['labor_assignment_id']){
            Log::debug('changed');
            $assignment = LaborAssignment::find($values['labor_assignment_id']);
            if(!$assignment->order_id){
                return response(['message' => "No order has been associated with assignment " . $assignment->name], 422);
            }
            $task = $this->getOrCreateAssignedTask($assignment,$request->user()->id,$values['clock_out']);
            $appointment = $this->getOrCreateAssignedAppointment($task,$request->user()->id,$values['clock_out']);
            $values['appointment_id'] = $appointment->id;
        }
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
    
    private function getOrCreateAssignedTask($assignment,$user_id,$time){
        $task = Task::select('tasks.id')
            ->where('order_id',$assignment->order_id)
            ->where('labor_assignment_id', $assignment->id)
            ->leftJoin('appointments','tasks.id','=','appointments.task_id')
            ->orderBy('appointments.date','DESC')
            ->orderBy('tasks.created_at','DESC')
            ->first();
        if(!$task){
            $task = Task::create([
               'order_id' => $assignment->order_id,
               'name' => $assignment->name,
               'labor_type_id' => $assignment->labor_type_id,
               'labor_assignment_id' => $assignment->id,
               'completion_date' => $time,
               'closed_date' => $time,
               'creator_id' => $user_id,
               'updater_id' => $user_id
            ]);
        }
        else{
            $task->update([
                'completion_date' => $time,
                'closed_date' => $time,
            ]);
        }
        return $task;
    }
    
    private function getOrCreateAssignedAppointment($task,$user_id,$time){
        $appointment = Appointment::where('task_id',$task->id)
            ->where('date',date('Y-m-d',strtotime($time)))
            ->orderBy('time','DESC')
            ->first();
        if(!$appointment){
            $appointment = Appointment::create([
               'task_id' => $task->id,
               'date' => $time,
               'time' => $time,
               'creator_id' => $user_id,
               'updater_id' => $user_id
            ]);
        }
        return $appointment;
    }
}