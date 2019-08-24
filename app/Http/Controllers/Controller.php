<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    protected $model_validation = [];
    protected $model_validation_required = [];
    protected $model_includes = [];
    
    public function validateModel($request, $validate_required = false){
        $this->validate($request, $this->model_validation);
        error_log(print_r($this->model_validation,true));
        if($validate_required){
            $this->validate($request, $this->model_validation_required);
        }
        return $request->only(array_keys($this->model_validation));
    }
    
    public function validateIncludes($includes){
        if($includes == ""){
                return [];
        }
        $includes_array = explode(',', $includes);
        return array_intersect($includes_array, $this->model_includes);
    }
}
