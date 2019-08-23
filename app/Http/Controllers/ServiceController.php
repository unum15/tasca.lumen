<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $items = Service::all();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $item = Service::create($request->input());
        return response(['data' => $item], 201, ['Location' => route('service.read', ['id' => $item->id])]);
    }

    public function read($id)
    {
        $item = Service::findOrFail($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = Service::findOrFail($id);
        $item->update($request->input());
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = Service::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
}

