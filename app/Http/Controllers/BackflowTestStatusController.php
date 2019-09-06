<?php

namespace App\Http\Controllers;

use App\BackflowTestStatus;
use Illuminate\Http\Request;

class BackflowTestStatusController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $items = BackflowTestStatus::all();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $item = BackflowTestStatus::create($request->input());
        return response(['data' => $item], 201, ['Location' => route('backflow_test_status.read', ['id' => $item->id])]);
    }

    public function read($id)
    {
        $item = BackflowTestStatus::findOrFail($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = BackflowTestStatus::findOrFail($id);
        $item->update($request->input());
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = BackflowTestStatus::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
}

