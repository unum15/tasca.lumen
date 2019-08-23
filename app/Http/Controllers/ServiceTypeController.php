<?php

namespace App\Http\Controllers;

use App\ServiceType;
use Illuminate\Http\Request;

class ServiceTypeController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $items = ServiceType::all();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $item = ServiceType::create($request->input());
        return response(['data' => $item], 201, ['Location' => route('service_type.read', ['id' => $item->id])]);
    }

    public function read($id)
    {
        $item = ServiceType::findOrFail($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = ServiceType::findOrFail($id);
        $item->update($request->input());
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = ServiceType::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
}

