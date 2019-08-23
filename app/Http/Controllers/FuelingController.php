<?php

namespace App\Http\Controllers;

use App\Fueling;
use Illuminate\Http\Request;

class FuelingController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $items = Fueling::all();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $item = Fueling::create($request->input());
        return response(['data' => $item], 201, ['Location' => route('fueling.read', ['id' => $item->id])]);
    }

    public function read($id)
    {
        $item = Fueling::findOrFail($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = Fueling::findOrFail($id);
        $item->update($request->input());
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = Fueling::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
}

