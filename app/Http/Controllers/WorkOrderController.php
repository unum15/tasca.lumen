<?php

namespace App\Http\Controllers;

use App\WorkOrder;
use Illuminate\Http\Request;

class WorkOrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $validation_create = [
        'project_id' => 'integer|exists:projects,id',
        'completion_date' => 'date',
        'expiration_date' => 'date',
        'priority_id' => 'integer',
        'work_type_id' => 'integer',
        'crew' => 'integer',
        'total_hours' => 'integer',
        'location' => 'string|max:255',
        'instructions' => 'string|max:255',
        'notes' => 'string|max:255',
        'purchase_order_number' => 'string|max:255',
        'budget' => 'string|max:255',
        'budget_plus_minus' => 'integer',
        'budget_invoice_number' => 'string|max:255',
		'bid' => 'string|max:255',
		'bid_plus_minus' => 'string|max:255',
        'invoice_number' => 'integer'
    ];
    
    private $validation = [
        'project_id' => 'integer|exists:projects,id',
        'completion_date' => 'date',
        'expiration_date' => 'date',
        'priority_id' => 'integer',
        'work_type_id' => 'integer',
        'crew' => 'integer',
        'total_hours' => 'integer',
        'location' => 'string|max:255',
        'instructions' => 'string|max:255',
        'notes' => 'string|max:255',
        'purchase_order_number' => 'string|max:255',
        'budget' => 'string|max:255',
        'budget_plus_minus' => 'integer',
        'budget_invoice_number' => 'string|max:255',
		'bid' => 'string|max:255',
		'bid_plus_minus' => 'string|max:255',
        'invoice_number' => 'integer'
    ];
    
    public function __construct()
    {
        //
    }

    public function index(Request $request){
        $this->validate($request, $this->validation);
        $values = $request->only(array_keys($this->validation));
        $items_query = WorkOrder::with('project', 'project.property', 'project.contact', 'project.property.client')
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
        $item = WorkOrder::create($values);
        $item = WorkOrder::findOrFail($item->id);
        return $item;
    }
    
    public function read($id){
        $item = WorkOrder::findOrFail($id);
        return $item;
    }
    
    public function update($id, Request $request){
        $this->validate($request, $this->validation);     
        $item = WorkOrder::findOrFail($id);
        $values = $request->only(array_keys($this->validation));
        $values['updater_id'] = $request->user()->id;
        $item->update($values);
        return $item;
    }
    
    public function delete($id){
        $item = WorkOrder::findOrFail($id);
        $item->delete();
        return response([], 204);
    }    

}
