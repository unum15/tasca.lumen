<?php

namespace App\Http\Controllers;

use App\Property;
use Illuminate\Http\Request;
use Log;

class PropertyController extends Controller
{
    private $validation = [
        'name' => 'string|min:1|max:255',
        'client_id' => 'integer|exists:clients,id',
        'notes' => 'nullable|string|max:255',
        'phone_number' => 'nullable|string|max:255',
        'address1' => 'nullable|string|max:255',
        'address2' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:255', 
        'state' => 'nullable|string|max:255',
        'zip' => 'nullable|string|max:255',
        'work_property' => 'boolean',
        'address_type_id' => 'integer|exists:address_types,id', 
        'activity_level_id' => 'integer|exists:activity_levels,id',
        'property_type_id' => 'integer|exists:property_types,id',
        'abbreviation' => 'nullable|string|max:255',
        'coordinates' => 'nullable|string|max:255',
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->validate($request, $this->validation);
        $this->validate($request, ['maximium_activity_level_id' => 'nullable|integer|exists:activity_levels,id']);
        $items_query = Property::with('client')
            ->with('activityLevel')
            ->with('propertyType')
            ->with('contacts')
            ->with('propertyUnits')
            ->orderBy('name');
        $values = $request->only(array_keys($this->validation));
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $max_activity_level = $request->input('maximium_activity_level_id');
        if(!empty($max_activity_level)) {
            $items_query->where('activity_level_id','<=',$max_activity_level);
        }
        $items = $items_query->get();
        return $items;
    }
    
    public function create(Request $request)
    {
        $this->validate($request, $this->validation);
        $this->validate($request, ['name' => 'required']);
        $values = $request->only(array_keys($this->validation));
        $values = $request->input();
        $values['creator_id'] = $request->user()->id;
        $values['updater_id'] = $request->user()->id;
        $item = Property::create($values);
        $item = Property::findOrFail($item->id);
        $contacts = $request->input('contacts');
        $item->contacts()->sync($contacts);
        return $item;
    }
    
    public function read($id)
    {
        $item = Property::findOrFail($id);
        return $item;
    }
    
    public function update($id, Request $request)
    {
        $this->validate($request, $this->validation);     
        $item = Property::findOrFail($id);
        $values = $request->only(array_keys($this->validation));
        $values['updater_id'] = $request->user()->id;
        $item->update($values);
        $contacts = $request->input('contacts');
        $item->contacts()->sync($contacts);
        return $item;
    }
    
    public function delete($id)
    {
        $item = Property::findOrFail($id);
        $item->delete();
        return response([], 204);
    }    

}
