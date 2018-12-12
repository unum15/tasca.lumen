<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $validation = [
        'description' => 'string|min:1|max:255',
		'project_id' => 'integer|exists:projects,id',
        'order_billing_type_id' => 'integer|exists:order_billing_types,id',
        'date' => 'date',
        'notes' => 'nullable|string|max:255'
    ];
    
    public function __construct()
    {
        //
    }

    public function index(Request $request){
        $this->validate($request, $this->validation);
        $values = $request->only(array_keys($this->validation));
        $items_query = Order::with('project', 'project.property', 'project.contact', 'project.property.client')
        ->orderBy('date');
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        return $items_query->get();
    }
    
    public function create(Request $request){
        $this->validate($request, $this->validation);
        //$values = $request->only(array_keys($this->validation));
        $values = $request->input();
        $values['creator_id'] = $request->user()->id;
        $values['updater_id'] = $request->user()->id;
        $item = Order::create($values);
        $item = Order::findOrFail($item->id);
        return $item;
    }
    
    public function read($id){
        $item = Order::findOrFail($id);
        return $item;
    }
    
    public function update($id, Request $request){
        $this->validate($request, $this->validation);     
        $item = Order::findOrFail($id);
        $values = $request->only(array_keys($this->validation));
        $values['updater_id'] = $request->user()->id;
        $item->update($values);
        return $item;
    }
    
    public function delete($id){
        $item = Order::findOrFail($id);
        $item->delete();
        return response([], 204);
    }    

}
