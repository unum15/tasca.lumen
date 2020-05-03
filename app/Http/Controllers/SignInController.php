<?php

namespace App\Http\Controllers;

use App\SignIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SignInController extends Controller
{
    private $validation = [
        'task_date_id' => 'integer|exists:task_dates,id',
        'clock_in_id' => 'integer|exists:clock_ins,id',
        'overhead_assignment_id' => 'integer|exists:overhead_assignments,id',
        'overhead_category_id' => 'integer|exists:overhead_categories,id',
        'sign_in' => 'string|max:255',
        'sign_out' => 'string|max:255',
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
        $items_query = SignIn::with(
            'TaskDate',
            'TaskDate.Task',
            'TaskDate.Task.Order',
            'OverheadAssignment',
            'OverheadCategory',
            'ClockIn',
            'ClockIn.Contact',
            'TaskDate.Task.Order.Project',
            'TaskDate.Task.Order.Project.Client'
        )
        ->orderBy('sign_in');
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $task_id = $request->input('task_id');
        if(!empty($task_id)) {
            $items_query->whereHas(
                'TaskDate', function ($q) use ($task_id) {
                    $q->where('task_dates.task_id', $task_id);
                }
            );
        }
        $order_id = $request->input('order_id');
        if(!empty($order_id)) {
            $items_query->whereHas(
                'TaskDate.Task', function ($q) use ($order_id) {
                    $q->where('tasks.order_id', $order_id);
                }
            );
        }
        $start_date = $request->input('start_date');
        if(!empty($start_date)) {
            $items_query->where(DB::raw('sign_in::DATE'), '>=', $start_date);
        }
        $stop_date = $request->input('stop_date');
        if(!empty($stop_date)) {
            $items_query->where(DB::raw('sign_out::DATE'), '<=', $stop_date);
        }


        return $items_query->get();
    }
    
    public function by_employee(Request $request)
    {
        $validation = [
            'task_date_id' => 'integer|exists:task_dates,id',
            'task_id' => 'integer|exists:tasks,id',
            'order_id' => 'integer|exists:orders,id',
            'project_id' => 'integer|exists:projects,id',
        ];
        $this->validate($request, $validation);
        $values = $request->only(array_keys($validation));
        $items_query = DB::table('sign_ins')
            ->leftJoin('task_dates', 'sign_ins.task_date_id', '=', 'task_dates.id')
            ->leftJoin('tasks', 'task_dates.task_id', '=', 'tasks.id')
            ->leftJoin('orders', 'tasks.order_id', '=', 'orders.id')
            ->leftJoin('clock_ins', 'sign_ins.clock_in_id', '=', 'clock_ins.id')
            ->leftJoin('contacts', 'clock_ins.contact_id', '=', 'contacts.id')
            ->select(
                DB::raw('ROUND((EXTRACT(EPOCH FROM SUM(sign_out-sign_in))/3600)::NUMERIC, 2) AS hours'),
                'contacts.id',
                'contacts.name',
                DB::raw('10.00 AS rate')
            )
            ->groupBy('contacts.id', 'contacts.name')
            ->orderBy('contacts.name');
            ;
        if(!empty($values['task_id'])) {
             $items_query->where('task_dates.task_id', $values['task_id']);
        }
        if(!empty($values['order_id'])) {
             $items_query->where('tasks.order_id', $values['order_id']);
        }
        return $items_query->get();
    }
    
    public function create(Request $request)
    {
        $this->validate($request, $this->validation);
        $values = $request->only(array_keys($this->validation));
        $values = $request->input();
        $values['creator_id'] = $request->user()->id;
        $values['updater_id'] = $request->user()->id;
        $item = SignIn::create($values);
        $item = SignIn::with(
            'TaskDate',
            'TaskDate.Task',
            'OverheadAssignment',
            'OverheadCategory',
            'ClockIn',
            'ClockIn.Contact'
        )
            ->findOrFail($item->id);
        return $item;
    }
    
    public function read($id)
    {
        $item = SignIn::with(
            'TaskDate',
            'TaskDate.Task',
            'OverheadAssignment',
            'OverheadCategory',
            'ClockIn',
            'ClockIn.Contact'
        )
        ->findOrFail($id);
        return $item;
    }
    
    public function current(Request $request)
    {
        $item = SignIn::with([
            'TaskDate',
            'TaskDate.Task',
            'OverheadAssignment',
            'OverheadCategory',
            'ClockIn',
            'ClockIn.Contact'
            ]
        )
        ->whereHas('clockIn', function ($q) use ($request){
                $q->where('contact_id', $request->user()->id)
                ->whereNull('clock_out')
                ->whereRaw('clock_in::DATE=NOW()::DATE');
        })
        ->whereNull('sign_out')
        ->orderByDesc('sign_in')
        ->first();
        return $item;
    }
    
    public function update($id, Request $request)
    {
        $this->validate($request, $this->validation);     
        $item = SignIn::findOrFail($id);
        $values = $request->only(array_keys($this->validation));
        $values['updater_id'] = $request->user()->id;
        $item->update($values);
        $item = SignIn::with(
            'TaskDate',
            'TaskDate.Task',
            'OverheadAssignment',
            'OverheadCategory',
            'ClockIn',
            'ClockIn.Contact'
        )
        ->findOrFail($id);
        return $item;
    }
    
    public function delete($id)
    {
        $item = SignIn::findOrFail($id);
        $item->delete();
        return response([], 204);
    }    

}
