<?php

namespace App\Http\Controllers\Api;


use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{

    public function index()
    {
        $categorys = Category::all();

        if(count($categorys) > 0){
            return response()->json($categorys);
        }else{
            return response()->json("Nenhuma categoria encontrada.");
        }

    }

    public function categorysWithProducts()
    {
        $categorys = Category::all();
        $retorno = [];
        foreach($categorys as $category){
            // dd(count($category->produtos));
            if(count($category->produtos) > 0){
                array_push($retorno, $category);
            }
        }
        if(count($retorno) > 0){
            return response()->json($retorno);
        }else{
            return response()->json("Nenhuma categoria encontrada.");
        }

    }

    public function store(Request $request)
    {
        $new = new Category();
        $category = [
            'name'                  =>  $request->name,
            'description'           =>  $request->description,
            'image'                 =>  $request->image !== "" ? $request->image : 'imagem_padrao',
            'tenant_id'             =>  Auth::user()->tenant_id,
        ];
        $new->fill($category);
        $new->save();

        return response()->json($new, 201);
    }

    public function show($id)
    {
        $category = Category::find($id);

        if(!$category) {
            return response()->json([
                'message'   => 'Categoria não encontrado',
            ], 404);
        }

        return response()->json($category);
    }

    public function update(Request $request,$id)
    {
        $category = Category::find($id);
        $data = $request->all();

        if(!$category) {
            return response()->json([
                'message'   => 'Categoria não encontrado',
            ], 404);
        }

        $category->fill($data);
        $category->save();

        return response()->json($category);
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if(!$category) {
            return response()->json([
                'message'   => 'Categoria não encontrado',
            ], 404);
        }
        $category->delete();

        return response()->json($category);
    }
}
