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
		'contact_id' => 'nullable|integer|exists:contacts,id',
        'notes' => 'nullable|string|max:255'
    ];
    
    public function __construct()
    {
        //
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
