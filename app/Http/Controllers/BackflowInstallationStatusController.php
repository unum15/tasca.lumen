<?php

namespace App\Http\Controllers;

use App\BackflowInstallationStatus;
use Illuminate\Http\Request;

class BackflowInstallationStatusController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $items = BackflowInstallationStatus::all();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $item = BackflowInstallationStatus::create($request->input());
        return response(['data' => $item], 201, ['Location' => route('backflow_installation_status.read', ['id' => $item->id])]);
    }

    public function read($id)
    {
        $item = BackflowInstallationStatus::findOrFail($id);
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = BackflowInstallationStatus::findOrFail($id);
        $item->update($request->input());
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = BackflowInstallationStatus::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
}

