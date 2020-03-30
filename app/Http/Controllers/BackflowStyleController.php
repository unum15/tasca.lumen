<?php

namespace App\Http\Controllers;

use App\BackflowStyle;
use Illuminate\Http\Request;

class BackflowStyleController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $items = BackflowStyle::all();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $item = BackflowStyle::create($request->input());
        return response(['data' => $item], 201, ['Location' => route('backflow_style.read', ['id' => $item->id])]);
    }

    public function read($id)
    {
        $item = BackflowStyle::findOrFail($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = BackflowStyle::findOrFail($id);
        $item->update($request->input());
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = BackflowStyle::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
}

