<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Product;
use App\Stock;
use Illuminate\Http\Request;
use JWTAuth;

class StockController extends Controller
{
    public function getStocks(Request $request)
    {
        return response()->json([
            'data' => JWTAuth::parseToken()->authenticate()
                ->stocks()
                ->with('feedback')
                ->orderBy('created_at', 'desc')
                ->get()
                ->each(function ($stock, $key) {
                    $stock['total_price'] = $stock->totalPrice();
                    $stock['total_quantity'] = $stock->totalQuantity();
                }),
        ]);
    }

    public function getStockDetails(Request $request, $stock_id)
    {
        $stock = JWTAuth::parseToken()->authenticate()
            ->stocks()
            ->find($stock_id);

        $stock['items'] = $stock->products()->getFullByDate($stock->created_at);
        $stock['total_price'] = $stock->totalPrice();
        $stock['total_quantity'] = $stock->totalQuantity();

        return response()->json([
            'data' => $stock,
        ]);
    }

    public function postStocks(Request $request)
    {
        $stock = new Stock();
        $stock->status = 0;

        $user = JWTAuth::parseToken()->authenticate();
        $user->stocks()->save($stock);

        foreach ($request->all() as $json) {
            $product = Product::find($json['product']['id']);
            $stock->products()->save($product, [
                'grade' => $json['grade'],
                'quantity' => $json['quantity'],
            ]);
        }

        foreach ($stock->products as $product) {
            $product->active_counter += 1;
            $product->save();
        }

        $user->active_counter += 1;
        $user->save();

        return response()->json([
            'data' => $stock,
        ]);
    }

}
