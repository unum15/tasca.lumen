<?php

namespace App\Http\Controllers;

use App\AccountsTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AccountsTableController extends Controller
{
    public function __construct()
    {
        Log::debug('AccountsTableController Constructed');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $values = $this->validateModel($request);
        $items_query = AccountsTable::with($includes);
        foreach($values as $field => $value){
            $items_query->where($field, $value);
        }
        $items = $items_query->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = AccountsTable::create($values);
        return response(['data' => $item], 201, ['Location' => route('accounts_table.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = AccountsTable::with($includes)->find($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = AccountsTable::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = AccountsTable::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
    
    protected $model_validation = [
    ];
    
    protected $model_validation_required = [
    ];
}