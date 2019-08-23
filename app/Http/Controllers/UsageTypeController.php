<?php

namespace App\Http\Controllers;

use App\UsageType;
use Illuminate\Http\Request;

class UsageTypeController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $items = UsageType::all();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $item = UsageType::create($request->input());
        return response(['data' => $item], 201, ['Location' => route('usage_type.read', ['id' => $item->id])]);
    }

    public function read($id)
    {
        $item = UsageType::findOrFail($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = UsageType::findOrFail($id);
        $item->update($request->input());
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = UsageType::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
}

