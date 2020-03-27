<?php

namespace App\Http\Controllers;

use App\BackflowOld;
use App\Property;
use App\BackflowAssembly;

use App\BackflowType;
use App\BackflowWaterSystem;
use App\BackflowSize;
use App\BackflowManufacturer;
use App\BackflowModel;

use Illuminate\Http\Request;

class BackflowOldController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = BackflowOld::with($includes);
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $items_query->whereNull('backflow_assembly_id');
        $items = $items_query->get();
        return ['data' => $items];
    }
    
    public function zips(Request $request)
    {
        $items = BackflowOld::distinct()->orderBy('zip')->get(['zip'])->pluck('zip');
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = BackflowOld::create($values);
        return response(['data' => $item], 201, ['Location' => route('backflow_old.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = BackflowOld::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = BackflowOld::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = BackflowOld::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
    
    public function export($id, Request $request)
    {
        $item = BackflowOld::findOrFail($id);
        $property_id = $request->input('property_id');
        $unit_id = $request->input('unit_id');
        if(empty($property_id)){
            $item->update(['backflow_assembly_id' => 0]);
            return [];
        }
        $property = Property::findOrFail($property_id);
        $contacts = $property->contacts();
        $contact_id = null;
        if($contacts->count()){
            $contact_id = $contacts->first()->id;
        }
        $backflow_type = BackflowType::where('name', 'ilike', trim($item->style))->first();
        $backflow_water_system = BackflowWaterSystem::where('name', 'ilike', trim($item->water_system))->first();
        $size = trim($item->size);
        $size = preg_replace('/["\s]/','',$size);
        $backflow_size = BackflowSize::where('name', $size)->first();
        $backflow_manufacturer = BackflowManufacturer::where('name', 'ilike', trim($item->manufacturer))->first();
        $backflow_model = BackflowModel::where('name', 'ilike', trim($item->model))->first();
        
        if(!$backflow_type){
            return response(['message' => 'Bad backflow type, can not import.'], 422);
        }
        if(!$backflow_water_system){
            $backflow_water_system = BackflowWaterSystem::create(['name' => ucwords(strtolower($item->water_system))]);
        }
        if(!$backflow_size){
            $backflow_size = BackflowSize::create(['name' => $item->size]);
        }
        if(!$backflow_manufacturer){
            $backflow_manufacturer = BackflowManufacture::create(['name' => ucwords(strtolower($item->manufacturer))]);
        }
        if(!$backflow_model){
            $backflow_model = BackflowModel::create(['name' => $item->model, 'backflow_manufacturer_id' => $backflow_manufacturer->id, 'backflow_type_id' => $backflow_type->id]);
        }
        
        $backflow_assembly = BackflowAssembly::create([
            'property_id' => $property_id,
            'property_unit_id' => $unit_id ? $unit_id : null,
            'contact_id' => $contact_id,
            'backflow_type_id' => $backflow_type->id,
            'backflow_water_system_id' => $backflow_water_system->id,
            'backflow_size_id' => $backflow_size->id,
            'backflow_manufacturer_id' => $backflow_manufacturer->id,
            'backflow_model_id' => $backflow_model->id,
            'month'=>$item->month,
            'use'=>$item->use,
            'placement'=>$item->placement,
            'gps'=>$item->gps,
            'serial_number'=>$item->serial,
            'notes'
        ]);
        $item->update(['backflow_assembly_id' => $backflow_assembly->id]);
        return ['data' => $backflow_assembly];
    }
    
    protected $model_validation = [
       'active' => 'string|max:1020',
       'prt' => 'string|max:1020',
       'month' => 'string|max:1020',
       'reference' => 'string|max:1020',
       'water_system' => 'string|max:1020',
       'account' => 'string|max:1020',
       'owner' => 'string|max:1020',
       'contact' => 'string|max:1020',
       'email' => 'string|max:1020',
       'phone' => 'string|max:1020',
       'address' => 'string|max:1020',
       'city' => 'string|max:1020',
       'state' => 'string|max:1020',
       'zip' => 'string|max:1020',
       'location' => 'string|max:1020',
       'laddress' => 'string|max:1020',
       'lcity' => 'string|max:1020',
       'lstate' => 'string|max:1020',
       'lzip' => 'string|max:1020',
       'gps' => 'string|max:1020',
       'use' => 'string|max:1020',
       'placement' => 'string|max:1020',
       'style' => 'string|max:1020',
       'manufacturer' => 'string|max:1020',
       'size' => 'string|max:1020',
       'model' => 'string|max:1020',
       'serial' => 'string|max:1020',
       'backflow_assembly_id' => 'integer',
    ];
    
    protected $model_validation_required = [
       'active' => 'required',
       'prt' => 'required',
       'month' => 'required',
       'reference' => 'required',
       'water_system' => 'required',
       'account' => 'required',
       'owner' => 'required',
       'contact' => 'required',
       'email' => 'required',
       'phone' => 'required',
       'address' => 'required',
       'city' => 'required',
       'state' => 'required',
       'zip' => 'required',
       'location' => 'required',
       'laddress' => 'required',
       'lcity' => 'required',
       'lstate' => 'required',
       'lzip' => 'required',
       'gps' => 'required',
       'use' => 'required',
       'placement' => 'required',
       'style' => 'required',
       'manufacturer' => 'required',
       'size' => 'required',
       'model' => 'required',
       'serial' => 'required',
    ];
}