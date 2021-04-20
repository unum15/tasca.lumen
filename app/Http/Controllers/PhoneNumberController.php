<?php

namespace App\Http\Controllers;

use App\PhoneNumber;
use Illuminate\Http\Request;

class PhoneNumberController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    private $validation = [
        'phone_number' => 'string|min:10|max:64',
        'phone_number_type_id' => 'integer|exists:phone_number_types,id',        
        'contact_id' => 'integer|exists:contacts,id'
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $items_query = PhoneNumber::orderBy('phone_number_type_id');
        $contact_id = $request->input('contact_id');
        if($contact_id != '') {
            $items_query = $items_query->where('contact_id', $contact_id);
        }
        $phone_number = $request->input('phone_number');
        if($phone_number != '') {
            $items_query = $items_query->where('phone_number', $phone_number);
        }
        $includes = $this->validateIncludes($request->input('includes'));
        $items_query->with($includes);
        $items = $items_query->get();
        return $items;
    }
    
    public function create(Request $request)
    {
        $this->validate($request, $this->validation);
        $this->validate($request, ['phone_number' => 'required', 'phone_number_type_id' => 'required', 'contact_id' => 'required']);
        $values = $request->only(array_keys($this->validation));
        $values['creator_id'] = $request->user()->id;
        $values['updater_id'] = $request->user()->id;
        $item = PhoneNumber::create($values);
        $item = PhoneNumber::findOrFail($item->id);
        return $item;
    }
    
    public function read($id)
    {
        $item = PhoneNumber::findOrFail($id);
        return $item;
    }
    
    public function update($id, Request $request)
    {
        $this->validate($request, $this->validation);     
        $item = PhoneNumber::findOrFail($id);
        $values = $request->only(array_keys($this->validation));
        $values['updater_id'] = $request->user()->id;
        $item->update($values);
        return $item;
    }
    
    public function delete($id)
    {
        $item = PhoneNumber::findOrFail($id);
        $item->delete();
        return response([], 204);
    }    

    protected $model_includes = [
        'contact',
        'phoneNumberType'
    ];
}
