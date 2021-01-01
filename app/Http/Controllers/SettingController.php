<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SettingController extends Controller
{
    private $validation = [
        'name' => 'string|required|min:1|max:255'
    ];

    public function __construct()
    {

    }

    public function index()
    {
        $items = Setting::pluck('value', 'name');
        return $items;
    }
    
    public function create(Request $request)
    {
        $this->middleware('auth');
        if($request->user()->cannot('edit-settings')) {
            abort(403);
        }
        $this->validate($request, $this->validation);
        $item = ContactMethod::Setting($request->input());
        return $item;
    }
    
    public function read($id)
    {
        $item = Setting::findOrFail($id);
        return $item;
    }

    public function update(Request $request)
    {
        $this->middleware('auth');
        if($request->user()->cannot('edit-settings')) {
            abort(403);
        }
        $settings = $request->all();
        foreach($settings as $setting => $value){
            $setting = Setting::where('name', $setting)->first();
            $setting->update(['value' => $value]);
        }
    }
    
    public function delete($id)
    {
        $this->middleware('auth');
        if(!$request->user()->can('edit-settings')) {
            return response(['Unauthorized(permissions)'], 401);
        }
        $item = Setting::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
}
