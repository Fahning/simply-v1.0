<?php

namespace App\Http\Controllers\Api;

use App\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{

    public function index()
    {
        $brands = Brand::all();
        if(count($brands) > 0){
            return response()->json($brands);
        }else{
            return response()->json("Nenhuma marca encontrada.");
        }
    }

    public function store(Request $request)
    {
        $new = new Brand();
        $brand = [
            'name'                  =>  $request->name,
            'description'           =>  $request->description,
            'image'                 =>  $request->image,
            'tenant_id'             =>  Auth::user()->tenant_id,
        ];
        $new->fill($brand);
        $new->save();

        return response()->json($new, 201);
    }

    public function show(Brand $brand)
    {
        //
    }

    public function update(Request $request, Brand $brand)
    {
        //
    }

    public function destroy(Brand $brand)
    {
        //
    }
}
