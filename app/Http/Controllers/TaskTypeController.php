<?php
namespace App\Http\Controllers;
use App\TaskType;
use Illuminate\Http\Request;
class TaskTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    protected $model_validation = [
        'name' => 'string|required|min:1|max:255',
        'notes' => 'string|max:255|nullable',
        'sort_order' => 'integer|nullable',
    ];
    public function index()
    {
        $items = TaskType::all();
        return $items;
    }
    public function create(Request $request)
    {
        $values = $this->validateModel($request);
        $item = TaskType::create($values);
        return $item;
    }
    public function read($id)
    {
        $item = TaskType::findOrFail($id);
        return $item;
    }
    public function update($id, Request $request)
    {
        $values = $this->validateModel($request);
        $item = TaskType::findOrFail($id);
        $item->update($values);
        return $item;
    }
    public function delete($id)
    {
        $item = TaskType::findOrFail($id);
        $item->delete();
        return response([], 204);
    }
}
