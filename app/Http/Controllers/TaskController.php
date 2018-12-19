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
        'description' => 'nullable|string|max:255',
        'name' => 'nullable|string|max:255',
        'billable' => 'nullable|boolean',
        'task_type_id' => 'nullable|integer:exists:task_types,id',
        'task_status_id' => 'nullable|integer:exists:task_statuses,id',
        'task_action_id' => 'nullable|integer:exists:task_actions,id',
        'task_category_id' => 'nullable|integer:exists:task_category,id',
        'day' => 'nullable|string|max:255',
        'date' => 'nullable|date',
        'completion_date' => 'nullable|date',
        'time' => 'nullable|string|max:255',
        'job_hours' => 'nullable|integer',
        'crew_hours' => 'nullable|integer',
        'notes' => 'nullable|string|max:255',
        'sort_order' => 'nullable|integer',
        'order_id' => 'integer|exists:orders,id',
        'notes' => 'nullable|string|max:255',
        'group' => 'nullable|string|max:255'
    ];
    
    public function __construct()
    {
        //
    }

    public function index(Request $request){
        $this->validate($request, $this->validation);
        $values = $request->only(array_keys($this->validation));
        $items_query = Task::with('order', 'order.project', 'order.project.property', 'order.project.contact', 'order.project.property.client', 'TaskCategory')
        ->orderBy('id');
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $items_query->whereHas(
            'order' , function($q){
                $q->whereNull('completion_date');
                $q->whereNull('expiration_date');
                $q->whereNotNull('approval_date');
            }
        );
        
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
        $item = Task::findOrFail($id);
        return $item;
    }
    
    public function update($id, Request $request){
        $this->validate($request, $this->validation);     
        $item = Task::findOrFail($id);
        $values = $request->only(array_keys($this->validation));
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
