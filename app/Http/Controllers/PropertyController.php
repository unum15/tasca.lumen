<?php

namespace App\Http\Controllers;

use App\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $validation = [
        'name' => 'string|min:1|max:255',
		'client_id' => 'integer|exists:clients,id',
		'primary_contact_id' => 'nullable|integer|exists:contacts,id',
        'notes' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:255',
        'address1' => 'nullable|string|max:255',
        'address2' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:255', 
        'state' => 'nullable|string|max:255',
        'zip' => 'nullable|string|max:255',
        'work_property' => 'boolean',
        'address_type_id' => 'integer|exists:address_types,id', 
        'activity_level_id' => 'integer|exists:activity_levels,id',
		'property_type_id' => 'integer|exists:property_types,id'
    ];
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $items = Property::with('client')
        ->with('activityLevel')
        ->with('propertyType')
        ->with('contact')
        ->get();
        return $items;
    }
    
    public function create(Request $request){
        $this->validate($request, $this->validation);
        $values = $request->only(array_keys($this->validation));
        $values = $request->input();
        $values['creator_id'] = $request->user()->id;
        $values['updater_id'] = $request->user()->id;
        $item = Property::create($values);
        $item = Property::findOrFail($item->id);
        return $item;
    }
    
    public function read($id){
        $item = Property::findOrFail($id);
        return $item;
    }
    
    public function update($id, Request $request){
        $this->validate($request, $this->validation);     
        $item = Property::findOrFail($id);
        $values = $request->only(array_keys($this->validation));
        $values['updater_id'] = $request->user()->id;
        $item->update($values);
        return $item;
    }
    
    public function delete($id){
        $item = Property::findOrFail($id);
        $item->delete();
        return response([], 204);
    }    

}
