<?php

namespace App\Http\Controllers;

use App\Inventory;
use App\Promotion;
use App\Wastage;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter_date = $request->input('filter_date', '');

        if ($request->has('filter_date')) {
            $inventories = Inventory::with('product', 'price', 'orders', 'stocks')
                ->whereDate('created_at', '=', $filter_date)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $inventories = Inventory::with('product', 'price', 'orders', 'stocks')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('inventories.index', compact('inventories', 'filter_date'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexWastages()
    {
        $wastages = Wastage::all();
        return view('inventories.wastages.index', compact('wastages'));
    }

    public function indexPromotions()
    {
        $promotions = Promotion::all();
        return view('inventories.promotions.index', compact('promotions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
