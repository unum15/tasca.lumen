<?php

namespace App\Http\Controllers;

use App\Repair;
use Illuminate\Http\Request;

class RepairController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $items = Repair::all();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $item = Repair::create($request->input());
        return response(['data' => $item], 201, ['Location' => route('repair.read', ['id' => $item->id])]);
    }

    public function read($id)
    {
        $item = Repair::findOrFail($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = Repair::findOrFail($id);
        $item->update($request->input());
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = Repair::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
}

