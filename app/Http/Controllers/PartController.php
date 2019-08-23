<?php

namespace App\Http\Controllers;

use App\Part;
use Illuminate\Http\Request;

class PartController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $items = Part::all();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $item = Part::create($request->input());
        return response(['data' => $item], 201, ['Location' => route('part.read', ['id' => $item->id])]);
    }

    public function read($id)
    {
        $item = Part::findOrFail($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = Part::findOrFail($id);
        $item->update($request->input());
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = Part::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
}

