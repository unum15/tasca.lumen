<?php

namespace App\Http\Controllers;

use App\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $items = Vehicle::all();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $item = Vehicle::create($request->input());
        return response(['data' => $item], 201, ['Location' => route('vehicle.read', ['id' => $item->id])]);
    }

    public function read($id)
    {
        $item = Vehicle::findOrFail($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = Vehicle::findOrFail($id);
        $item->update($request->input());
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = Vehicle::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
}

