<?php

namespace App\Http\Controllers;

use App\BackflowCertification;
use Illuminate\Http\Request;

class BackflowCertificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $items = BackflowCertification::with($includes)->get();
        return ['data' => $items];
    }

    public function create(Request $request)
    {
        $values = $this->validateModel($request, true);
        $item = BackflowCertification::create($values);
        return response(['data' => $item], 201, ['Location' => route('backflow_certification.read', ['id' => $item->id])]);
    }

    public function read($id, Request $request)
    {
        $includes = $this->validateIncludes($request->input('includes'));
        $item = BackflowCertification::find($id)->with($includes)->firstOrFail();
        return ['data' => $item];
    }

    public function update($id, Request $request)
    {
        $item = BackflowCertification::findOrFail($id);
        $values = $this->validateModel($request);
        $item->update($values);
        return ['data' => $item];
    }

    public function delete(Request $request, $id)
    {
        $item = BackflowCertification::findOrFail($id);
        $item->delete();
        return response([], 401);
    }
    
    protected $model_validation = [
       'backflow_assembly_id' => 'integer|exists:backflow_assemblies,id',
       'visual_inspection_notes' => 'string|max:1020',
       'backflow_installation_status_id' => 'integer',
    ];
    
    protected $model_validation_required = [
       'backflow_assembly_id' => 'required',
       'visual_inspection_notes' => 'required',
       'backflow_installation_status_id' => 'required',
    ];

    protected $model_includes = [
       'backflow_assembly'
    ];
    
}