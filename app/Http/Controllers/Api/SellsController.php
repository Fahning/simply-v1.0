<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Product;
use App\Sells;
use App\SellsProduct;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SellsController extends Controller
{
    public function newSell(Request $request){

        DB::beginTransaction();
        try{
            $sell               = new Sells();
            $sell->total_price  = $request->total_price;
            $sell->discount     = $request->discount;
            $sell->tenant_id    = Auth::user()->tenant_id;
            $sell->save();

            if($sell){
                foreach($request->products as $product){
                    $sell_product               = new SellsProduct();
                    $sell_product->sells_id     = $sell->id;
                    $sell_product->product_id   = $product['id'];
                    $sell_product->quantity     = $product['quantity'];
                    $sell_product->discount     = 0;
                    $sell_product->tenant_id    = Auth::user()->tenant_id;
                    $sell_product->save();
                    //REMOVE 1 UNIDADE DO ESTOQUE
                    $product = Product::find($sell_product->product_id);
                    $product->stock--;
                    $product->save();
                }
            }

            if( $sell && $sell_product ) {
                //Sucesso!
                DB::commit();
                return response()->json($sell_product, 201);
            } else {
                //Fail, desfaz as alterações no banco de dados
                DB::rollBack();
                return response()->json("Erro ao finalizar venda", 201);
            }

        }catch(Exception $e){
            //Fail, desfaz as alterações no banco de dados
            DB::rollBack();
            return response()->json("Erro ao finalizar venda : ". $e->getMessage(), 201);
        }

    }

    public function showAll(){
        $all = Sells::find(33);

        return response()->json($all->produtos, 201);

    }
//REFATORAR ESSE METODO
    public function sellsToday()
    {
        $dataHoje = Carbon::today();
        $dataHoje = $dataHoje->format('Y-m-d');
        $last30Days = Carbon::today()->subDays(30);
        $sells_last_month = Sells::where('created_at', '>=', date($last30Days))->sum('total_price');
        $sells_today = Sells::whereDate('created_at', $dataHoje)->sum('total_price');

        $sells = [
            'today' => $sells_today,
            'last30Days' => $sells_last_month
        ];
        if(!empty($sells)){
            return response()->json($sells, 200);
        }else{
            $sells = [
                'today' => 0,
                'last30Days' => 0
            ];
            return response()->json($sells, 200);
        }
    }

    public function tablesSells()
    {
        $productsToday = [];
        $dataHoje = Carbon::today()->format('Y-m-d');
        $sellsToday = Sells::whereDate('created_at', $dataHoje)->orderBy('created_at','DESC')->get();
        $qtd_today = count($sellsToday);
        foreach($sellsToday as $itensToday){
            foreach($itensToday->produtos as $itemToday){
                $itemToTable = $itemToday->produto;
                $itemToTable->total_price = $itemToday->quantity * $itemToTable->price;
                $itemToTable->quantity = $itemToday->quantity;
                $itemToTable->date = $itemToday->created_at->format('d/m/Y H:i');
                $itemToTable->discount = $itemToday->discount;
                array_push($productsToday, $itemToTable);
            }
        }
        //TABELA ULTIMOS 30 DIAS
        $products30Days = [];
        $last30Days = Carbon::today()->subDays(30);
        $sells_last_month = Sells::where('created_at', '>=', date($last30Days))->orderBy('created_at','DESC')->get();
        $qnt30days = count($sells_last_month);
        foreach($sells_last_month as $itens30Days){
            foreach($itens30Days->produtos as $item30Days){
                $itemToTable = $item30Days->produto;
                $itemToTable->total_price = $item30Days->quantity * $itemToTable->price;
                $itemToTable->quantity = $item30Days->quantity;
                $itemToTable->date = $item30Days->created_at->format('d/m/Y H:i');
                $itemToTable->discount = $item30Days->discount;
                array_push($products30Days, $itemToTable);
            }
        }
        $tableToday = [
            'tableToday' => $productsToday,
            'qntToday'   => $qtd_today,
            'last30Days' => $products30Days,
            'qnt30days'  => $qnt30days
        ];
        return response()->json($tableToday, 200);
    }
}
