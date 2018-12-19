<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $validation = [
        'name' => 'string|min:1|max:255',
		'property_id' => 'integer|exists:properties,id',
        'open_date' => 'date',
		'contact_id' => 'integer|exists:contacts,id',
        'close_date' => 'nullable|date',
        'notes' => 'nullable|string|max:255'
    ];
    
    public function __construct()
    {
        //
    }

    public function index(Request $request){
        $this->validate($request, $this->validation);
        $values = $request->only(array_keys($this->validation));
        $items_query = Project::with('contact', 'property', 'property.client')
        ->orderBy('name');
        $client_id = $request->input('client_id');
        if($client_id){
            $items_query->whereHas('property', function($q) use ($client_id){
                $q->where('client_id', $client_id);
            });
        }
        $completed = $request->input('completed');
        if($completed == 'false'){
            error_log('completed');
            $items_query->whereNull('close_date');
        }
        foreach($values as $filed => $value){
            $items_query->where($field, $value);
        }
        return $items_query->get();
    }
    
    public function create(Request $request){
        $this->validate($request, $this->validation);
        $values = $request->only(array_keys($this->validation));
        error_log(print_r($values, true));
        $values['creator_id'] = $request->user()->id;
        $values['updater_id'] = $request->user()->id;
        $item = Project::create($values);
        $item = Project::findOrFail($item->id);
        return $item;
    }
    
    public function read($id){
        $item = Project::findOrFail($id);
        return $item;
    }
    
    public function update($id, Request $request){
        $this->validate($request, $this->validation);
        $item = Project::findOrFail($id);
        $values = $request->only(array_keys($this->validation));
        $values['updater_id'] = $request->user()->id;
        $item->update($values);
        return $item;
    }
    
    public function delete($id){
        $item = Project::findOrFail($id);
        $item->delete();
        return response([], 204);
    }    

}
