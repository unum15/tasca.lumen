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
		'client_id' => 'integer|exists:clients,id',
        'open_date' => 'date',
		'contact_id' => 'integer|exists:contacts,id',
        'close_date' => 'nullable|date',
        'notes' => 'nullable|string|max:255'
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){
        $this->validate($request, $this->validation);
        $values = $request->only(array_keys($this->validation));
        $items_query = Project::with('contact', 'client')
        ->orderBy('name');
        $completed = $request->input('completed');
        if($completed == 'false'){
            $items_query->whereNull('close_date');
        }
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        return $items_query->get();
    }
    
    public function create(Request $request){
        $this->validate($request, $this->validation);
        $values = $request->only(array_keys($this->validation));
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
        $values['open_date'] = isset($values['open_date']) && $values['open_date'] != "" ? $values['open_date'] : null;
        $values['close_date'] = isset($values['close_date']) && $values['close_date'] != "" ? $values['close_date'] : null;
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
