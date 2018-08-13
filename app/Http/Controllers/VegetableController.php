<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Redirect;

class VegetableController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $vegetables = Product::orderBy('name', 'asc')->where('category_id', 11)->get();
        $categories = Category::all();
        return view('products.vegetables.index', compact('vegetables', 'categories'));
    }

    public function store(Request $request)
    {
        $awspath = $request->file('image')->store('public/images');

        $vegetable = new Product();
        $vegetable->name = $request->name;
        $vegetable->description = $request->description;
        $vegetable->short_description = $request->short_description;
        $vegetable->image = $awspath;
        $vegetable->category_id = 11;
        $vegetable->quantity_a = $request->quantity_a;
        $vegetable->quantity_b = $request->quantity_b;
        $vegetable->demand_a = $request->demand_a;
        $vegetable->demand_b = $request->demand_b;
        $vegetable->save();

        $vegetable->prices()->create([
            'seller_price_a' => $request->seller_price_a,
            'seller_price_b' => $request->seller_price_b,
            'buyer_price_a' => $request->buyer_price_a,
            'buyer_price_b' => $request->buyer_price_b,
            'date_price' => Carbon::today(),
        ]);

        return redirect()->route('products.vegetables.index');
    }

    public function edit($product_id)
    {
        $vegetable = Product::find($product_id);
        $categories = Category::all();
        return view('products.vegetables.edit', compact('vegetable', 'categories'));
    }

    public function update(Request $request, $product_id)
    {
        $vegetable = Product::find($product_id);

        if ($request->hasFile('image')) {
            Storage::delete($vegetable->image);
            $awspath = $request->file('image')->store('public/images');
            $vegetable->image = $awspath;
        }

        $vegetable->name = $request->name;
        $vegetable->description = $request->description;
        $vegetable->short_description = $request->short_description;
        $vegetable->category_id = 11;
        $vegetable->quantity_a = $request->quantity_a;
        $vegetable->quantity_b = $request->quantity_b;
        $vegetable->demand_a = $request->demand_a;
        $vegetable->demand_b = $request->demand_b;
        $vegetable->save();

        return redirect()->route('products.vegetables.index');
    }

    public function destroy($product_id)
    {
        Product::find($product_id)->delete();
        return redirect()->route('products.vegetables.index');
    }
}
