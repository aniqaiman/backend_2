<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Product;

class PriceController extends Controller
{
    public function getProductPriceLatest($product_id)
    {
        return response()->json([
            "data" => Product::find($product_id)->price_latest,
        ]);
    }

    public function getProductPriceDifference($product_id)
    {
        return response()->json([
            "data" => Product::find($product_id)->price_difference,
        ]);
    }
}
