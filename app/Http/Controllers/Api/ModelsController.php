<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\AssignOp\Mod;

class ModelsController extends Controller
{

    public function index()
    {
        $models = Models::all();
        if(count($models) > 0){
            return response()->json($models);
        }else{
            return response()->json("Nenhum modelo encontrado.");
        }

    }

    public function store(Request $request)
    {
        $new = new Models();
        $models = [
            'name'                  =>  $request->name,
            'description'           =>  $request->description,
            'image'                 =>  $request->image,
            'brand_id'              =>  $request->brand_id,
            'tenant_id'             =>  Auth::user()->tenant_id,
        ];
        $new->fill($models);
        $new->save();

        return response()->json($new, 201);
    }

    public function show($id)
    {
        $models = Models::find($id);

        if(!$models) {
            return response()->json([
                'message'   => 'Modelo não encontrado',
            ], 404);
        }

        return response()->json($models);
    }

    public function update(Request $request, $id)
    {
        $models = Models::find($id);
        $data = $request->all();

        if(!$models) {
            return response()->json([
                'message'   => 'Modelo não encontrado',
            ], 404);
        }

        $models->fill($data);
        $models->save();

        return response()->json($models);
    }

    public function destroy($id)
    {
        $models = Models::find($id);

        if(!$models) {
            return response()->json([
                'message'   => 'Modelo não encontrado',
            ], 404);
        }
        $models->delete();

        return response()->json($models);
    }
}
