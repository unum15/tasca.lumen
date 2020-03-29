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
use App\BackflowTest;
use App\BackflowTestReport;

use App\ActivityLevel;
use App\Client;
use App\ClientType;
use App\Contact;
use App\ContactMethod;
use App\ContactType;
use App\PropertyType;
use App\EmailType;
use App\PhoneNumberType;
use App\Email;
use App\PhoneNumber;

use Illuminate\Http\Request;

use Log;

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
        $items_query = BackflowOld::with($includes)->orderBy('owner')->orderBy('laddress')->orderBy('active')->orderBy('placement')->orderBy('id');
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $items_query->whereNull('backflow_assembly_id');
        $items = $items_query->get();
        return ['data' => $items];
    }
    
    public function zips(Request $request)
    {
        $items_query = BackflowOld::distinct();
        $group = $request->input('group');
        if(!empty($group)){
            $items_query->where('group',$group);
        }
        $items = $items_query->orderBy('zip')->get(['zip'])->pluck('zip');
        return ['data' => $items];
    }
    
    public function groups(Request $request)
    {
        $items = BackflowOld::distinct()->orderBy('group')->get(['group'])->pluck('group');
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
            Log::error($item);
            return response(['message' => 'Bad backflow type(' . $item->style . '), can not import.'], 422);
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
        $backflow_assembly = BackflowAssembly::where('property_id',$property_id)->where('serial_number', $item->serial)->first();
        if(!$backflow_assembly){
            $backflow_assembly = BackflowAssembly::create([
                'property_id' => $property_id,
                'property_unit_id' => $unit_id ? $unit_id : null,
                'contact_id' => $contact_id,
                'backflow_type_id' => $backflow_type->id,
                'backflow_water_system_id' => $backflow_water_system->id,
                'backflow_size_id' => $backflow_size->id,
                'backflow_manufacturer_id' => $backflow_manufacturer->id,
                'backflow_model_id' => $backflow_model->id,
                'active' => $item->active == 'Y',
                'month'=>$item->month,
                'use'=>$item->use,
                'placement'=>$item->placement,
                'gps'=>$item->gps,
                'serial_number'=>$item->serial,
                'notes'=>$item->notes
            ]);
        }
        $item->update(['backflow_assembly_id' => $backflow_assembly->id]);
        $old_backflow_assembly = BackflowAssembly::where('placement',$item->placement)->where('property_id',$property_id)->first();
        foreach($item->backflow_old_tests as $test){
            $reading_1 = $test->check_1 != "" ? $test->check_1 : $test->rp_check_1 != "" ? $test->rp_check_1 : $test->ail;
            $reading_2 = $test->check_2 != "" ? $test->check_2 : $test->rp != "" ? $test->rp : $test->ch_1;
            $reading_1 = $reading_1 != "" ? $reading_1 : null;
            $reading_2 = $reading_1 != "" ? $reading_1 : null;
            if(!empty($reading_1)&&(!is_numeric($reading_1))){
                $reading_1 = -1;
            }
            if(!empty($reading_2)&&(!is_numeric($reading_2))){
                $reading_2 = -1;
            }
            if($old_backflow_assembly){
                $old_backflow_test_report = BackflowTestReport::where('report_date',$test->test_date)->first();
                if($old_backflow_test_report){
                    $old_backflow_test = BackflowTest::where('reading_1', $reading_1)->where('reading_2',$reading_2)->first();
                    if($old_backflow_test){
                        continue;
                    }
                }
            }
            $backflow_test_report = BackflowTestReport::create([
                'backflow_assembly_id' => $backflow_assembly->id,
                'visual_inspection_notes' => null,
                'backflow_installed_to_code' => true,
                'report_date' => $test->test_date,
                'submitted_date' => $test->test_date,
                'notes' => null
            ]);
            Log::error($test);
            Log::error($reading_1);
            Log::error($reading_2);
            //return response([ 'message' => print_r($test, true)], 422);
            
            $backflow_test = BackflowTest::create([
                'backflow_test_report_id' => $backflow_test_report->id,
                'contact_id' => null,
                'reading_1' => $reading_1,
                'reading_2' => $reading_2,
                'passed' => true,
                'tested_on' => $test->test_date,
                'notes' => null
            ]);
        }
        return ['data' => $backflow_assembly];
    }
    
    
    public function exportClient($id, Request $request)
    {
        $item = BackflowOld::findOrFail($id);
        $activity_level_id = ActivityLevel::where('name', 'Level 3')->first()->id;
        $property_type_id = PropertyType::where('name', 'Office')->first()->id;
        $client_type_id = ClientType::where('name', 'Commercial')->first()->id;
        $contact_type_id = ContactType::where('name', 'Manager')->first()->id;
        $contact_method_id = ContactMethod::where('name', 'Call')->first()->id;
        $email_type_id = EmailType::where('name', 'Office')->first()->id;
        $phone_number_type_id = PhoneNumberType::where('name', 'Office')->first()->id;
        $client = Client::create([
            'name' => $item->owner,
            'activity_level_id' => $activity_level_id,
            'client_type_id' => $client_type_id,
            'notes' => 'Backflow report import',
            'creator_id' => $request->user()->id,
            'updater_id' => $request->user()->id
        ]);
        $property = $client->properties()->create([
            'name' => $item->owner,
            'activity_level_id' => $activity_level_id,
            'address1' => $item->address,
            'city' => $item->city,
            'state' => $item->state,
            'zip' => $item->zip,
            'work_property' => false,
            'billing_property' => false,
            'notes' => 'Backflow report import',
            'property_type_id' => $property_type_id,
            'creator_id' => $request->user()->id,
            'updater_id' => $request->user()->id
        ]);
        if(!empty($item->contact)){
            $contact = $client->contacts()->create([
                'name' => $item->contact,
                'activity_level_id' => $activity_level_id,
                'contact_method_id' => $contact_method_id,
                'notes' => 'Backflow report import',
                'creator_id' => $request->user()->id,
                'updater_id' => $request->user()->id
            ],['contact_type_id'=>$contact_type_id]);
            if(!empty($item->email)){
                $contact->emails()->create([
                    'email_type_id' => $email_type_id,
                    'email' => $item->email,
                    'creator_id' => $request->user()->id,
                    'updater_id' => $request->user()->id
                ]);
            }
            if(!empty($item->phone)){
                $contact->phoneNumbers()->create([
                    'phone_number_type_id' => $phone_number_type_id,
                    'phone_number' => $item->phone,
                    'creator_id' => $request->user()->id,
                    'updater_id' => $request->user()->id
                ]);
            }
        }
        return ['data' => $client];
    }

    public function exportProperty($id, Request $request)
    {
        $client_id = $request->input('client_id');
        $item = BackflowOld::findOrFail($id);
        $activity_level_id = ActivityLevel::where('name', 'Level 3')->first()->id;
        $property_type_id = PropertyType::where('name', 'Retail')->first()->id;
        $property = Property::create([
            'client_id' => $client_id,
            'name' => $item->location,
            'activity_level_id' => $activity_level_id,
            'address1' => $item->laddress,
            'city' => $item->lcity,
            'state' => $item->lstate,
            'zip' => $item->lzip,
            'work_property' => true,
            'billing_property' => false,
            'notes' => 'Backflow report import',
            'property_type_id' => $property_type_id,
            'creator_id' => $request->user()->id,
            'updater_id' => $request->user()->id
        ]);
        return ['data' => $property];
    }
    
    
    protected $model_validation = [
       'active' => 'string|max:1020',
       'prt' => 'string|max:1020',
       'month' => 'string|max:1020',
       'group' => 'string|max:1020',
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
       'notes' => 'string|max:1020',
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