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
    private $validation_create = [
        'name' => 'string|required|min:1|max:255',
        'contact_id' => 'integer|required|exists:contacts,id',
		'property_id' => 'integer|required|exists:properties,id',
        'open_date' => 'date|required',
        'close_date' => 'date',
        'notes' => 'string|max:255'
		
    ];
    
    private $validation = [
		'service_order_id' => 'integer|exists:service_orders,id',
        'notes' => 'nullable|string|max:255'
    ];
    
    public function __construct()
    {
        //
    }

    public function index(Request $request){
        $this->validate($request, $this->validation);
        $values = $request->only(array_keys($this->validation));
        $items_query = Task::with('service_order', 'service_order.project', 'service_order.project.property', 'service_order.project.contact', 'service_order.project.property.client')
        ->orderBy('id');
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        return $items_query->get();
    }
    
    public function create(Request $request){
        $this->validate($request, $this->validation_create);
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