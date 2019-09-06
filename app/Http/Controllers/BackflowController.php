<?php

namespace App\Http\Controllers;

use App\Backflow;
use Illuminate\Http\Request;

class BackflowController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $items = Backflow::all();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $item = Backflow::create($request->input());
        return response(['data' => $item], 201, ['Location' => route('backflow.read', ['id' => $item->id])]);
    }

    public function read($id)
    {
        $item = Backflow::findOrFail($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = Backflow::findOrFail($id);
        $item->update($request->input());
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = Backflow::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
}

