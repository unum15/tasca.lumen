<?php

namespace App\Http\Controllers;

use App\TaskAppointmentStatus;
use Illuminate\Http\Request;

class TaskAppointmentStatusController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $validation = [
        'name' => 'string|required|min:1|max:255',
        'notes' => 'string|max:255',
        'sort_order' => 'integer'
    ];
    
    public function __construct()
    {
        //
    }

    public function index(){
        $items = TaskAppointmentStatus::All();
        return $items;
    }
    
    public function create(Request $request){
        $this->validate($request, $this->validation);
        $this->removeConflict($request);
        $item = TaskAppointmentStatus::create($request->input());
        return $item;
    }
    
    public function read($id){
        $item = TaskAppointmentStatus::findOrFail($id);
        return $item;
    }
    
    public function update($id, Request $request){
        $this->validate($request, $this->validation);
        $this->removeConflict($request);
        $item = TaskAppointmentStatus::findOrFail($id);
        $item->update($request->input());
        return $item;
    }
    
    public function delete($id){
        $item = TaskAppointmentStatus::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    public function removeConflict(Request $request){
        $sort_order = $request->input('sort_order');
        $default = $request->input('default');
        if($sort_order){
            TaskAppointmentStatus::where('sort_order', $sort_order)
                ->update(['sort_order' => null]);
        }
    }
}
