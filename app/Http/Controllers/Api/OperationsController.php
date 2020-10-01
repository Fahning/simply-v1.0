<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Brand;
use App\Category;
use App\Models;
use Illuminate\Http\Request;

class OperationsController extends Controller
{
    public function selectOptions(){
        $categorys  = Category::select('id as value', 'name AS label')->get();
        $brands     = Brand::select('id as value', 'name AS label')->get();
        $models     = Models::select('id as value', 'name AS label')->get();
        $options = [
            'categorys' => [],
            'brands' => [],
            'models' => []
        ];
        //CATEGORYS
        array_push($options['categorys'], $categorys);
        //BRANDS
        array_push($options['brands'], $brands);
        //MODELS
        array_push($options['models'], $models);

        return response()->json($options);
    }
}
