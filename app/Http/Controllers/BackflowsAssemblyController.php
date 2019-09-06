<?php

namespace App\Http\Controllers;

use App\BackflowsAssembly;
use Illuminate\Http\Request;

class BackflowsAssemblyController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $items = BackflowsAssembly::all();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $item = BackflowsAssembly::create($request->input());
        return response(['data' => $item], 201, ['Location' => route('backflows_assembly.read', ['id' => $item->id])]);
    }

    public function read($id)
    {
        $item = BackflowsAssembly::findOrFail($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = BackflowsAssembly::findOrFail($id);
        $item->update($request->input());
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = BackflowsAssembly::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
}

