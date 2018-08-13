<?php

namespace App\Http\Controllers;

use App\Price;
use App\Product;
use App\Promotion;
use Illuminate\Http\Request;
use Redirect;
use Session;

class PriceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $productQuery = Product::all();
        $products = [];
        foreach ($productQuery as $product) {

            $product_prices = $product->price_today;
            $product_yest_prices = $product->price_yesterday;

            $newProd["id"] = $product["id"];
            $newProd["name"] = $product["name"];

            $product_yest_prices["seller_price_a"] ? $newProd["seller_yest_price_a"] = $product_yest_prices["seller_price_a"] : $newProd["seller_yest_price_a"] = 0.00;
            $product_yest_prices["seller_price_b"] ? $newProd["seller_yest_price_b"] = $product_yest_prices["seller_price_b"] : $newProd["seller_yest_price_b"] = 0.00;
            $product_yest_prices["buyer_price_a"] ? $newProd["buyer_yest_price_a"] = $product_yest_prices["buyer_price_a"] : $newProd["buyer_yest_price_a"] = 0.00;
            $product_yest_prices["buyer_price_b"] ? $newProd["buyer_yest_price_b"] = $product_yest_prices["buyer_price_b"] : $newProd["buyer_yest_price_b"] = 0.00;

            $product_prices["seller_price_a"] ? $newProd["seller_price_a"] = $product_prices["seller_price_a"] : $newProd["seller_price_a"] = $newProd["seller_yest_price_a"];
            $product_prices["seller_price_b"] ? $newProd["seller_price_b"] = $product_prices["seller_price_b"] : $newProd["seller_price_b"] = $newProd["seller_yest_price_b"];
            $product_prices["buyer_price_a"] ? $newProd["buyer_price_a"] = $product_prices["buyer_price_a"] : $newProd["buyer_price_a"] = $newProd["buyer_yest_price_a"];
            $product_prices["buyer_price_b"] ? $newProd["buyer_price_b"] = $product_prices["buyer_price_b"] : $newProd["buyer_price_b"] = $newProd["buyer_yest_price_b"];

            $newProd["difference"] = $product->price_today_yesterday_difference;

            array_push($products, $newProd);

        }

        return view('prices.index', compact('products'));
    }

    public function indexHistories(Request $request)
    {
        $filter_date = $request->input('filter_date', '');

        if ($request->has('filter_date')) {
            $prices = Price::whereDate('date_price', '=', $filter_date)
                ->orderBy('date_price', 'desc')
                ->get();
        } else {
            $prices = Price::orderBy('date_price', 'desc')->get();
        }

        return view('prices.histories.index', compact('prices', 'filter_date'));
    }

    public function getFruitDetail($product_id, Request $request)
    {
        $fruit = Product::where('id', $product_id)->first();
        $prices = Price::where('product_id', $product_id)->orderBy('price_id', 'desc')->get();
        $latestPrice = Price::where('product_id', $product_id)->orderBy('price_id', 'desc')->first();
        return view('price.fruitprice', compact('fruit', 'prices', 'latestPrice'));
    }

    public function createFruitPrice($product_id, Request $request)
    {
        if ($request->ajax()) {
            $price = new Price;
            $price->product_id = $product_id;
            $price->product_price = $request->product_price;
            $price->product_price2 = $request->product_price2;
            $price->product_price3 = $request->product_price3;
            $price->date_price = $request->date_price;
            $price->save();
            return response($price);
        }
    }

    public function editFruitPrice($product_id, $price_id, Request $request)
    {
        $fruit = Product::where('product_id', $product_id)->first();
        $prices = Price::where('price_id', $price_id)->first();
        return view('price.editFruitPrice', compact('prices', 'fruit'));
    }

    public function updateFruitPrice(Request $request)
    {
        if ($request->ajax()) {
            $product_price = Price::where('product_id', $request->product_id)->where('date_price', $request->date)->first();
            if (!$product_price) {
                $product_price = new Price();
                $product_price->seller_price_a = 0;
                $product_price->seller_price_b = 0;
                $product_price->buyer_price_a = 0;
                $product_price->buyer_price_b = 0;
                $product_price->product_id = $request->product_id;
                $product_price->date_price = $request->date;
            }
            if ($request->seller_price_a) {
                $product_price->seller_price_a = $request->seller_price_a;
            }
            if ($request->seller_price_b) {
                $product_price->seller_price_b = $request->seller_price_b;
            }
            if ($request->buyer_price_a) {
                $product_price->buyer_price_a = $request->buyer_price_a;
            }
            if ($request->buyer_price_b) {
                $product_price->buyer_price_b = $request->buyer_price_b;
            }
            $product_price->save();
            return response($product_price);
        }
    }

    public function deleteFruitPrice($price_id, Request $request)
    {
        $price = Price::find($price_id);
        $price->delete();
        Session::flash('message', 'Successfully deleted!');
        return Redirect::to('fruit/' . $price->product_id . '/detail');
    }

    public function createVegePrice($product_id, Request $request)
    {
        if ($request->ajax()) {
            $price = new Price;
            $price->product_id = $product_id;
            $price->product_price = $request->product_price;
            $price->product_price2 = $request->product_price2;
            $price->product_price3 = $request->product_price3;
            $price->date_price = $request->date_price;
            $price->save();
            return response($price);
        }
    }

    public function getVegeDetail($product_id, Request $request)
    {
        $vege = Product::where('product_id', $product_id)->first();
        $prices = Price::where('product_id', $product_id)->get();
        return view('price.vegeprice', compact('vege', 'prices'));
    }

    public function editVegePrice($product_id, $price_id, Request $request)
    {
        $prices = Price::where('price_id', $price_id)->first();
        return view('price.editVegePrice', compact('prices'));
    }

    public function updateVegePrice(Request $request)
    {
        if ($request->ajax()) {
            $prices = Price::where('price_id', $request->price_id)->first();
            $prices->product_id = $request->product_id;
            $prices->product_price = $request->product_price;
            $prices->date_price = $request->date_price;
            $prices->save();
            return response($prices);
        }
    }

    public function deleteVegePrice($price_id, Request $request)
    {
        $prices = Price::find($price_id);
        $prices->delete();
        Session::flash('message', 'Successfully deleted!');
        return Redirect::to('vegeprice');
    }

    public function getPriceDifference(Request $request)
    {
        return response()->json(
            Product::find($request->input("id"))->price_today_yesterday_difference
        );
    }
}
