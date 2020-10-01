<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Product;
use App\ProductCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::all();
        foreach($products as $product){
            $product->category = $product->category;
            $product->model = $product->model;
            $product->brand = $product->brand;
        };
        return response()->json($products);
    }

    public function seachByCategory($id)
    {
        $products = Product::where('category_id', $id)->get();
        // dd(products);
        return response()->json($products);
    }

    private function geraCodigo(){
        $codigo = ProductCode::all()->count() + 1;
        $codigo = str_pad($codigo, 10, 0, STR_PAD_LEFT);
        $cod = new ProductCode();
        $cod->tenant_id = Auth::user()->tenant_id;
        $cod->save();
        if ($cod){
            return $codigo;
        }else{
            return response()->json('Erro ao gerar codigo para o produto.', 401);
        }


    }

    public function store(Request $request)
    {

        $new = new Product();
        $product = [
            'code'                  =>  $this->geraCodigo(), //Criar metodo global
            'price'                 =>  $request->price,
            'image'                 =>  $request->image,
            'name'                  =>  $request->name,
            'stock'                 =>  $request->stock,
            'manufacturing_date'    =>  $request->manufacturing_date != null ? $request->manufacturing_date : date('Y-m-d'),
            'shelflife_date'        =>  $request->shelflife_date != null ? $request->shelflife_date : date('Y-m-d'),
            'tenant_id'             =>  Auth::user()->tenant_id,
            'brand_id'              =>  $request->brand_id != null ? $request->brand_id : 1,
            'model_id'              =>  $request->model_id != null ? $request->model_id : 1,
            'category_id'           =>  $request->category_id
        ];
        $new->fill($product);
        $new->save();

        return response()->json($new, 201);
    }

    public function show($id)
    {
        $product = Product::find($id);


        if(!$product) {
            return response()->json([
                'message'   => 'Produto não encontrado',
            ], 404);
        }

        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $data = $request->all();

        if(!$product) {
            return response()->json([
                'message'   => 'Produto não encontrado',
            ], 404);
        }

        $product->fill($data);
        $product->save();

        return response()->json($product);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if(!$product) {
            return response()->json([
                'message'   => 'Produto não encontrado',
            ], 404);
        }

        $product->delete();

        return response()->json($product);
    }
}
