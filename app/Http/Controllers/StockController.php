<?php

namespace App\Http\Controllers;

use App\Stock;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Redirect;
use Session;

class StockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function createStock(Request $request)
    {
        if ($request->ajax()) {
            $stocks = new Stock;
            $stock->product_id = $request->product_id;
            $stock->product_quantity = $request->product_quantity;
            $stock->product_grade = $request->product_grade;
            $stock->user_id = $request->user_id;
            $stocks->save();
            return response($stocks);
        }
    }

    public function getStock()
    {
        $stocks = Stock::all();
        return view('seller.sellerdetail', compact('stocks'));
    }

    public function editStock($stock_id, Request $request)
    {
        $stocks = Stock::where('stock_id', $request->stock_id)->first();
        return view('seller.editSellerDetail', compact('stocks'));
    }

    public function updateStock(Request $request)
    {
        if ($request->ajax()) {
            $stocks = Stock::where('stock_id', $request->stock_id)->first();
            $stock->product_id = $request->product_id;
            $stock->product_quantity = $request->product_quantity;
            $stock->product_grade = $request->product_grade;
            $stock->user_id = $request->user_id;
            $stocks->save();
            return response($stocks);
        }
    }

    public function deleteStock($stock_id, Request $request)
    {
        $stocks = Stock::find($stock_id);
        $stocks->delete();
        Session::flash('message', 'Successfully deleted!');
        return Redirect::to('sellerdetail');
    }

    public function assignDriverStocks(Request $request)
    {
        $stock = Stock::find($request->id);

        $client = new Client(['base_uri' => 'https://maps.googleapis.com/maps/api/distancematrix/']);
        $element = json_decode(
            $client->get("json?origins=" . env("WAREHOUSE")
                . "&destinations=" . $stock->user->latitude . "," . $stock->user->longitude
                . "&key=" . env("GMAP_KEY"))
                ->getBody()
        )
            ->rows[0]
            ->elements[0];

        $stock->lorry_id = $request->lorry_id;
        $stock->distance = isset($element->distance) ? round($element->distance->value / 1000, 2) : "0";
        $stock->save();

        return response($stock);
    }
}
