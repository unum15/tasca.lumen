<?php

namespace App\Http\Controllers;

use App\BackflowTest;
use Illuminate\Http\Request;

class BackflowTestController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $items = BackflowTest::all();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $item = BackflowTest::create($request->input());
        return response(['data' => $item], 201, ['Location' => route('backflow_test.read', ['id' => $item->id])]);
    }

    public function read($id)
    {
        $item = BackflowTest::findOrFail($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = BackflowTest::findOrFail($id);
        $item->update($request->input());
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = BackflowTest::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
}

