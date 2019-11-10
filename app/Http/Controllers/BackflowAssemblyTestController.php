<?php

namespace App\Http\Controllers;

use App\BackflowAssemblyTest;
use Illuminate\Http\Request;

class BackflowAssemblyTestController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $items = BackflowAssemblyTest::all();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $item = BackflowAssemblyTest::create($request->input());
        return response(['data' => $item], 201, ['Location' => route('backflow_assembly_test.read', ['id' => $item->id])]);
    }

    public function read($id)
    {
        $item = BackflowAssemblyTest::findOrFail($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = BackflowAssemblyTest::findOrFail($id);
        $item->update($request->input());
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = BackflowAssemblyTest::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
}

