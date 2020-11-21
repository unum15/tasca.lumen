<?php

namespace App\Http\Controllers;

use App\PropertyAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PropertyAccountController extends Controller
{
    public function __construct()
    {
        Log::debug('PropertyAccountController Constructed');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = PropertyAccount::with($includes);
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $items = $items_query->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = PropertyAccount::create($values);
        return response(['data' => $item], 201, ['Location' => route('property_account.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = PropertyAccount::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = PropertyAccount::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = PropertyAccount::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    protected $model_validation = [
       'property_id' => 'integer',
       'number' => 'string|max:1020',
       'name' => 'string|max:1020|nullable',
       'address' => 'string|max:1020|nullable',
       'city' => 'string|max:1020|nullable',
       'access_code' => 'string|max:1020|nullable',
       'notes' => 'string|max:1020|nullable',
    ];
    
    protected $model_validation_required = [
       'property_id' => 'required',
       'number' => 'required',
    ];
}