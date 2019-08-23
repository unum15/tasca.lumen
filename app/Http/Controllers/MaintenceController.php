<?php

namespace App\Http\Controllers;

use App\Maintence;
use Illuminate\Http\Request;

class MaintenceController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $items = Maintence::all();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $item = Maintence::create($request->input());
        return response(['data' => $item], 201, ['Location' => route('maintence.read', ['id' => $item->id])]);
    }

    public function read($id)
    {
        $item = Maintence::findOrFail($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = Maintence::findOrFail($id);
        $item->update($request->input());
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = Maintence::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
}

