<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Redirect;

class FruitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $fruits = Product::orderBy('name', 'asc')->where('category_id', 1)->get();
        $categories = Category::all();
        return view('products.fruits.index', compact('fruits', 'categories'));
    }

    public function store(Request $request)
    {
        $awspath = $request->file('image')->store('public/images');

        $fruit = new Product();
        $fruit->name = $request->name;
        $fruit->description = $request->description;
        $fruit->short_description = $request->short_description;
        $fruit->image = $awspath;
        $fruit->category_id = 1;
        $fruit->quantity_a = $request->quantity_a;
        $fruit->quantity_b = $request->quantity_b;
        $fruit->demand_a = $request->demand_a;
        $fruit->demand_b = $request->demand_b;
        $fruit->save();

        $fruit->prices()->create([
            'seller_price_a' => $request->seller_price_a,
            'seller_price_b' => $request->seller_price_b,
            'buyer_price_a' => $request->buyer_price_a,
            'buyer_price_b' => $request->buyer_price_b,
            'date_price' => Carbon::today(),
        ]);

        return redirect()->route('products.fruits.index');
    }

    public function edit($product_id)
    {
        $fruit = Product::find($product_id);
        $categories = Category::all();
        return view('products.fruits.edit', compact('fruit', 'categories'));
    }

    public function update(Request $request, $product_id)
    {
        $fruit = Product::find($product_id);

        if ($request->hasFile('image')) {
            Storage::delete($fruit->image);
            $awspath = $request->file('image')->store('public/images');
            $fruit->image = $awspath;
        }

        $fruit->name = $request->name;
        $fruit->description = $request->description;
        $fruit->short_description = $request->short_description;
        $fruit->category_id = 1;
        $fruit->quantity_a = $request->quantity_a;
        $fruit->quantity_b = $request->quantity_b;
        $fruit->demand_a = $request->demand_a;
        $fruit->demand_b = $request->demand_b;
        $fruit->save();

        return redirect()->route('products.fruits.index');
    }

    public function destroy($product_id)
    {
        Product::find($product_id)->delete();
        return redirect()->route('products.fruits.index');
    }
}
