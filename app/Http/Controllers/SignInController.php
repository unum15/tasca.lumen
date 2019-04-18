<?php

namespace App\Http\Controllers;

use App\SignIn;
use Illuminate\Http\Request;

class SignInController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $validation = [
		'contact_id' => 'integer|exists:contacts,id',
        'task_date_id' => 'integer|exists:task_dates,id',
        'sign_in' => 'string|max:255',
        'sign_out' => 'string|max:255',
        'notes' => 'nullable|string|max:255'
    ];

    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index(Request $request){
        $this->validate($request, $this->validation);
        $values = $request->only(array_keys($this->validation));
        $items_query = SignIn::with(
            'TaskDate',
            'TaskDate.Task',
            'TaskDate.Task.Order',
            'Contact',
            'TaskDate.Task.Order.Project',
            'TaskDate.Task.Order.Project.Client'
        )
        ->orderBy('sign_in');
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $start_date = $request->input('start_date');
        if(!empty($start_date)){
            $items_query->where('sign_in::DATE', '>=', $start_date);
        }
        
        $stop_date = $request->input('stop_date');
        if(!empty($stop_date)){
            $items_query->where('sign_out::DATE', '>=', $stop_date);
        }
        
        
        return $items_query->get();
    }
    
    public function create(Request $request){
        $this->validate($request, $this->validation);
        $values = $request->only(array_keys($this->validation));
        $values = $request->input();
        $values['contact_id'] = $request->user()->id;
        $values['creator_id'] = $request->user()->id;
        $values['updater_id'] = $request->user()->id;
        $item = SignIn::create($values);
        $item = SignIn::with(
            'TaskDate',
            'Contact'
        )
        ->findOrFail($item->id);
        return $item;
    }
    
    public function read($id){
        $item = SignIn::with(
            'TaskDate',
            'Contact'
        )
        ->findOrFail($id);
        return $item;
    }
    
    public function update($id, Request $request){
        $this->validate($request, $this->validation);     
        $item = SignIn::findOrFail($id);
        $values = $request->only(array_keys($this->validation));
        $values['updater_id'] = $request->user()->id;
        $item->update($values);
        $item = SignIn::with(
            'TaskDate',
            'Contact'
        )
        ->findOrFail($id);
        return $item;
    }
    
    public function delete($id){
        $item = SignIn::findOrFail($id);
        $item->delete();
        return response([], 204);
    }    

}
