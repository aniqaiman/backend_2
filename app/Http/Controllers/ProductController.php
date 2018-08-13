<?php

namespace App\Http\Controllers;

use App\Product;
use App\Promotion;
use App\Wastage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function updateDemand(Request $request)
    {
        $product = Product::find($request->input('id'));

        if ($request->input('grade') === 'A') {
            $product->demand_a = $request->input('demand');
        } else if ($request->input('grade') === 'B') {
            $product->demand_b = $request->input('demand');
        }

        $product->save();        
        return response()->json($product);
    }

    public function updateWastage(Request $request)
    {
        $wastage = Wastage::where('product_id', $request->product_id)->first();

        if (!$wastage) {
            $wastage = new Wastage;
            $wastage["storage_wastage"] = 0;
            $wastage["promo_wastage"] = 0;

        }
        $wastage->product_id = $request->product_id;
        $wastage["storage_wastage"] += $request->wastage;
        $wastage->save();
        return response()->json($wastage);
    }

    public function updatePromo(Request $request)
    {
        $promo = Promotion::where('product_id', $request->product_id)->first();

        if (!$promo) {
            $promo = new Promotion;
            $promo["quantity"] = 0;

        }
        $promo->product_id = $request->product_id;
        $promo["quantity"] += $request->quantity;
        $promo->save();
        return response()->json($promo);
    }

    public function updatePromoPrice(Request $request)
    {
        $promo = Promotion::where('product_id', $request->product_id)->first();
        $promo->price = $request->price;
        $promo->save();

        return response()->json($promo);
    }

    public function updatePromoWastage(Request $request)
    {
        if ($request->promo_wastage < 1) {
            return response()->json([
                "message" => "Wastage must be at least 1.",
            ], 404);
        }

        $promo = Promotion::find($request->promo_id);

        if ($promo->totalRemaining() < $request->promo_wastage) {
            return response()->json([
                "message" => "Wastage is greater than remaining quantity.",
            ], 400);
        }

        $promo->wastage = $request->promo_wastage;
        $promo->save();

        $wastage = Wastage::where('product_id', $request->product_id)->first();
        if (!$wastage) {
            $wastage = new Wastage;
            $wastage["storage_wastage"] = 0;
            $wastage["promo_wastage"] = 0;
            $wastage["product_id"] = $request->product_id;
            $wastage["buy_at_price"] = $promo->buy_at_price;
        }

        $wastage->promo_wastage += $request->promo_wastage;
        $wastage->save();
        
        return response()->json($wastage);
    }
}
