<?php

namespace App\Http\Controllers;

use App\BackflowInstallationStatute;
use Illuminate\Http\Request;

class BackflowInstallationStatuteController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $items = BackflowInstallationStatute::all();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $item = BackflowInstallationStatute::create($request->input());
        return response(['data' => $item], 201, ['Location' => route('backflow_installation_statute.read', ['id' => $item->id])]);
    }

    public function read($id)
    {
        $item = BackflowInstallationStatute::findOrFail($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = BackflowInstallationStatute::findOrFail($id);
        $item->update($request->input());
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = BackflowInstallationStatute::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
}

