<?php

namespace App\Http\Controllers;

use App\Client;
use App\Setting;
use Illuminate\Http\Request;
use log;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        if(($request->user())&&(!$request->user()->can('view-clients'))) {
            return response(['Unauthorized(permissions)'], 401);
        }
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $this->validate($request, $this->model_validation);
        $this->validate($request, ['maximium_activity_level_id' => 'nullable|integer|exists:activity_levels,id']);
        $query = Client::orderBy('name');
        $query->with($includes);
        
        $max_activity_level = $request->input('maximium_activity_level_id');
        if(!empty($max_activity_level)) {
            $query->where('activity_level_id','<=',$max_activity_level);
        }
        $backflow_only = $request->input('backflow_only');
        if(!empty($backflow_only)&&$backflow_only=='true') {
            $query->whereHas('properties.backflow_assemblies', function($query){
                $query->where('active','true');
            });
        }
        $zip = $request->input('zip');
        if(!empty($zip)) {
            $query->whereHas('properties', function($query) use ($zip){
                $query->where('zip', 'like', "$zip%");
            });
        }
        $values = $request->only(array_keys($this->model_validation));
        foreach($values as $field => $value){
            $query->where($field, $value);
        }
        $items = $query->get();
        return $items;
    }
    
    public function create(Request $request)
    {
        if(!$request->user()->can('edit-clients')) {
            return response(['Unauthorized(permissions)'], 401);
        }
        $this->validate($request, ['name' => 'required']);
        $this->validate($request, $this->validation);
        $values = $request->only(array_keys($this->validation));
        #sometimes the form saves while loading 
        if(!$values['client_type_id']){
            return;
        }
        $values['creator_id'] = $request->user()->id;
        $values['updater_id'] = $request->user()->id;
        $item = Client::create($values);
        $item = Client::findOrFail($item->id);
        return $item;
    }
    
    public function read($id)
    {
        $item = Client::with(
            'contacts',
            'contacts.properties',
            'contacts.roles',
            'properties',
            'properties.contacts',
            'properties.propertyUnits',
            'linkedProperties',
            'linkedProperties.contacts',
            'linkedProperties.propertyUnits'
        )
        ->findOrFail($id);
        return $item;
    }
    
    public function update($id, Request $request)
    {
        if(!$request->user()->can('edit-clients')) {
            return response(['Unauthorized(permissions)'], 401);
        }
        $this->validate($request, $this->model_validation);     
        $item = Client::findOrFail($id);
        $values = $request->only(array_keys($this->model_validation));
        $values['updater_id'] = $request->user()->id;
        $item->update($values);
        return $item;
    }
    
    public function delete(Request $request, $id)
    {
        if(!$request->user()->can('edit-clients')) {
            return response(['Unauthorized(permissions)'], 401);
        }
        $item = Client::findOrFail($id);
        $item->delete();
        return response([], 204);
    }    

    public function unique($field)
    {
        if(!in_array($field,array_keys($this->model_validation))){
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'field' => ['Field is not a valid field for Project'],
            ]);
            throw $error;
        }
        $mininium = Setting::where('name','mininium-auto-suggest-count')->first();
        $items = Client::whereNotNull($field)->where($field,'!=','')->groupBy($field)->having(DB::raw('COUNT(*)'),'>=',$mininium['value'])->orderBy($field)->pluck($field);
        return ['data' => $items];
    }

    public function addProperty($id, Request $request)
    {
        if(!$request->user()->can('edit-clients')) {
            return response(['Unauthorized(permissions)'], 401);
        }
        $this->validate($request, ['property_id'  => 'nullable|integer|exists:properties,id']);
        $values = $request->only(['property_id']);
        $item = Client::findOrFail($id);
        $item->linkedProperties()->attach($values['property_id']);
        return $item;
    }
    
    public function deleteProperty($id, $property_id, Request $request)
    {
        if(!$request->user()->can('edit-clients')) {
            return response(['Unauthorized(permissions)'], 401);
        }
        $item = Client::findOrFail($id);
        $item->linkedProperties()->detach($property_id);
        return response([], 204);
    }

    private $model_validation = [
        'name'                      => 'string|min:1|max:255',
        'notes'                     => 'nullable|string|max:255',
        'client_type_id'            => 'nullable|integer|exists:client_types,id',
        'activity_level_id'         => 'nullable|integer|exists:activity_levels,id',
        'billing_contact_id'        => 'nullable|integer|exists:contacts,id',
        'main_mailing_property_id'  => 'nullable|integer|exists:properties,id',
        'contact_method_id'         => 'nullable|integer|exists:contact_methods,id',
        'referred_by'               => 'nullable|string|max:255',
        'abbreviation'              => 'nullable|string|max:255',
        'phreebooks_id'             => 'nullable|integer',

    ];
    
    protected $model_validation_required = [
       'name' => 'required'
    ];

    protected $model_includes = [
        'activityLevel',
        'billingContact',
        'billingProperty',
        'clientType',
        'contactMethod',
        'contacts',
        'properties',
        'linkedProperties',
        'contacts.phoneNumbers'
    ];
}
