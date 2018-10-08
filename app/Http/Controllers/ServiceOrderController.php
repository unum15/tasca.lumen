<?php

namespace App\Http\Controllers;

use App\ServiceOrder;
use Illuminate\Http\Request;

class ServiceOrderController extends Controller
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
        'name' => 'string|required|min:1|max:255',
		'property_id' => 'integer|exists:properties,id',
        'open_date' => 'date',
		'contact_id' => 'integer|exists:contacts,id',
        'close_date' => 'date',
        'notes' => 'string|max:255'
    ];
    
    public function __construct()
    {
        //
    }

    public function index(){
        $items = ServiceOrder::All();
        return $items;
    }
    
    public function create(Request $request){
        $this->validate($request, $this->validation_create);
        $values = $request->only(array_keys($this->validation));
        $values['creator_id'] = $request->user()->id;
        $values['updater_id'] = $request->user()->id;
        $item = ServiceOrder::create($values);
        $item = ServiceOrder::findOrFail($item->id);
        return $item;
    }
    
    public function read($id){
        $item = ServiceOrder::findOrFail($id);
        return $item;
    }
    
    public function update($id, Request $request){
        $this->validate($request, $this->validation);     
        $item = ServiceOrder::findOrFail($id);
        $values = $request->only(array_keys($this->validation));
        $values['updater_id'] = $request->user()->id;
        $item->update($values);
        return $item;
    }
    
    public function delete($id){
        $item = ServiceOrder::findOrFail($id);
        $item->delete();
        return response([], 204);
    }    

}
