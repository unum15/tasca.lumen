<?php

namespace App\Http\Controllers;

use App\VehicleType;
use Illuminate\Http\Request;

class VehicleTypeController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $items = VehicleType::all();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $item = VehicleType::create($request->input());
        return response(['data' => $item], 201, ['Location' => route('vehicle_type.read', ['id' => $item->id])]);
    }

    public function read($id)
    {
        $item = VehicleType::findOrFail($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = VehicleType::findOrFail($id);
        $item->update($request->input());
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = VehicleType::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
}

