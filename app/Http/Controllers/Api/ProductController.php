<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Price;
use App\Product;
use DB;
use Illuminate\Http\Request;
use JWTAuth;

class ProductController extends Controller
{
    public function getMinimalProducts()
    {
        return response()->json([
            "data" => Product::getMinimal(),
        ]);
    }

    public function getFruits()
    {
        return response()->json([
            "data" => Product::getFullByCategory(1),
        ]);
    }

    public function getVegetables()
    {
        return response()->json([
            "data" => Product::getFullByCategory(11),
        ]);
    }

    public function getFruitsByPage()
    {
        return response()->json(
            Product::getFullByCategory(1)->paginate(30)
        );
    }

    public function getVegetablesByPage()
    {
        return response()->json(
            Product::getFullByCategory(11)->paginate(30)
        );
    }

    public function getMinimalFruitsByPage()
    {
        return response()->json(
            Product::getMinimalByCategory(1)->paginate(30)
        );
    }

    public function getMinimalVegetablesByPage()
    {
        return response()->json(
            Product::getMinimalByCategory(11)->paginate(30)
        );
    }

    public function getMinimalFruits()
    {
        return response()->json([
            "data" => Product::getMinimalByCategory(1),
        ]);
    }

    public function getMinimalVegetables()
    {
        return response()->json([
            "data" => Product::getMinimalByCategory(11),
        ]);
    }

    public function getNewProducts(Request $request)
    {
        return response()->json([
            "data" => Product::take(10)->getFullPromotion(),
        ]);
    }

    public function getLastPurchaseProducts(Request $request)
    {
        $lastPurchaseProducts = Product::whereHas("orders", function ($orders) { 
            $user = JWTAuth::parseToken()->authenticate();
            $orders->where("user_id", $user->id);
        });

        return response()->json([
            "data" => $lastPurchaseProducts->take(10)->getFullPromotion(),
        ]);
    }

    public function getBestSellingProducts(Request $request)
    {
        return response()->json([
            "data" => Product::orderBy('active_counter', 'desc')->take(10)->getFullPromotion(),
        ]);
    }

}
