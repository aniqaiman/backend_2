<?php

namespace App\Http\Controllers;

use App\Feedback;
use App\Inventory;
use App\Order;
use App\Product;
use App\Promotion;
use App\Stock;
use App\User;
use Carbon\Carbon;
use DB;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Redirect;
use Session;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $orders = new Order;
            $orders->user_id = $request->user_id;
            $orders->product_id = $request->product_id;
            $orders->item_quantity = $request->item_quantity;
            $orders->product_price = $request->product_price;
            $orders->promo_price = $request->promo_price;
            $orders->save();
            return response($orders);
        }
    }

    public function indexOrderReceipts()
    {
        $orders = Order::where('status', 0)
            ->paginate(10, ['*'], 'buyer');

        $stocks = Stock::where('status', 0)
            ->paginate(10, ['*'], 'seller');

        $order_active = isset($_GET['buyer']) || !isset($_GET['seller']) ? "active" : "";
        $stock_active = isset($_GET['seller']) ? "active" : "";

        return view('orders.receipts', compact('orders', 'stocks', 'order_active', 'stock_active'));
    }

    public function indexOrderTrackings()
    {
        $orders = Order::whereIn('status', [1, 3, 4])
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'buyer');

        $stocks = Stock::whereIn('status', [1, 3, 4])
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'seller');

        $drivers = User::where('group_id', 31)
            ->get();

        $order_active = isset($_GET['buyer']) || !isset($_GET['seller']) ? "active" : "";
        $stock_active = isset($_GET['seller']) ? "active" : "";

        return view('orders.trackings', compact('orders', 'stocks', 'order_active', 'stock_active', 'drivers'));
    }

    public function indexOrderRejects()
    {
        $orders = Order::where('status', 2)
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'buyer');

        $stocks = Stock::where('status', 2)
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'seller');

        $order_active = isset($_GET['buyer']) || !isset($_GET['seller']) ? "active" : "";
        $stock_active = isset($_GET['seller']) ? "active" : "";

        return view('orders.feedbacks', compact('orders', 'stocks', 'order_active', 'stock_active'));
    }

    public function indexBuyerOrderTransactions(Request $request)
    {
        $filter_date = $request->input('filter_date', '');

        if ($request->has('filter_date')) {
            $orders = Order::with('user', 'products.prices')
                ->whereDate('created_at', '=', $filter_date)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $orders = Order::with('user', 'products.prices')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        $pending_orders = $orders->where('status', '<', 3);
        $completed_orders = $orders->where('status', '>=', 3);

        return view('orders.buyers.index', compact('orders', 'pending_orders', 'completed_orders', 'filter_date'));
    }

    public function indexSellerOrderTransactions(Request $request)
    {
        $filter_date = $request->input('filter_date', '');

        if ($request->has('filter_date')) {
            $stocks = Stock::with('user', 'products.prices')
                ->whereDate('created_at', '=', $filter_date)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $stocks = Stock::with('user', 'products.prices')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        $pending_stocks = $stocks->where('status', '<', 3);
        $completed_stocks = $stocks->where('status', '>=', 3);

        return view('orders.sellers.index', compact('stocks', 'pending_stocks', 'completed_stocks', 'filter_date'));
    }

    public function indexLorries(Request $request)
    {
        $filter_date = $request->input('filter_date', '');

        // $client = new Client(['base_uri' => 'https://maps.googleapis.com/maps/api/distancematrix/']);
        // $warehouse = "3.123093,101.468913";

        if ($request->has('filter_date')) {
            $ordersQuery = Order::with('user', 'driver')
                ->orderBy('lorry_id')
                ->whereDate('created_at', '=', $filter_date)
                ->whereHas('driver')
                ->get();
            $stocksQuery = Stock::with('user', 'driver')
                ->orderBy('lorry_id')
                ->whereDate('created_at', '=', $filter_date)
                ->whereHas('driver')
                ->get();
        } else {
            $ordersQuery = Order::with('user', 'driver')
                ->orderBy('lorry_id')
                ->whereHas('driver')
                ->get();
            $stocksQuery = Stock::with('user', 'driver')
                ->orderBy('lorry_id')
                ->whereHas('driver')
                ->get();
        }

        $orders = [];
        $locations = [];

        foreach ($ordersQuery as $order) {
            $newOrder["date"] = $order->created_at;
            $newOrder["driver_name"] = $order->driver->name;
            $newOrder["driver_id"] = $order->driver->id;
            $newOrder["id"] = $order->id;
            $newOrder["user_name"] = $order->user->name;
            $newOrder["user_id"] = $order->user->id;
            $newOrder["user_address"] = $order->user->address;
            $newOrder["latitude"] = $order->user->latitude;
            $newOrder["longitude"] = $order->user->longitude;
            $newOrder["tonnage"] = DB::table('order_product')->where('order_id', $order->id)->sum('quantity');
            $newOrder["distance"] = $order->distance;
            $newOrder["total_payout"] = DB::table('order_product')->where('order_id', $order->id)->sum('quantity') * 0.2;

            
            

            array_push($orders, $newOrder);
            array_push($locations, $order->user->latitude . "," . $order->user->longitude);
        }

        // $distances = empty($locations) ? [] : json_decode(
        //     $client->get("json?origins=" . implode("|", $locations) . "&destinations=$warehouse&key=" . env("GMAP_KEY"))
        //         ->getBody()
        // )->rows;

        // foreach ($orders as $key => $order) {
        //     $orders[$key]["distance"] = isset($distances[$key]->elements[0]->distance) ? round($distances[$key]->elements[0]->distance->value / 1000, 2) : "0";
        //     $orders[$key]["total_payout"] = $orders[$key]["distance"] * 0.2;
        // }

        $stocks = [];
        $locations = [];

        foreach ($stocksQuery as $stock) {
            $newStock["date"] = $stock->created_at;
            $newStock["driver_name"] = $stock->driver->name;
            $newStock["driver_id"] = $stock->driver->id;
            $newStock["id"] = $stock->id;
            $newStock["user_name"] = $stock->user->name;
            $newStock["user_id"] = $stock->user->id;
            $newStock["user_address"] = $stock->user->address;
            $newStock["latitude"] = $stock->user->latitude;
            $newStock["longitude"] = $stock->user->longitude;
            $newStock["tonnage"] = DB::table('product_stock')->where('stock_id', $stock->id)->sum('quantity');
            $newStock["distance"] = $stock->distance;
            $newStock["total_payout"] = DB::table('product_stock')->where('stock_id', $stock->id)->sum('quantity') * 0.2;

            array_push($stocks, $newStock);
            array_push($locations, $stock->user->latitude . "," . $stock->user->longitude);
        }

        // $distances = empty($locations) ? [] : json_decode(
        //     $client->get("json?destinations=" . implode("|", $locations) . "&origins=$warehouse&key=" . env("GMAP_KEY"))
        //         ->getBody()
        // )->rows[0]->elements;

        // foreach ($stocks as $key => $stock) {
        //     $stocks[$key]["distance"] = isset($distances[$key]->distance) ? round($distances[$key]->distance->value / 1000, 2) : "0";
        //     $stocks[$key]["total_payout"] = $stocks[$key]["distance"] * 0.2;
        // }

        // Grouping

        // $orders = collect($orders)
        //     ->groupBy('driver_id')
        //     ->each(function ($item, $key) {
        //         $orders[$key] = $item->sortBy('distance');
        //     });

        // $stocks = collect($stocks)
        //     ->groupBy('driver_id')
        //     ->each(function ($item, $key) {
        //         $stocks[$key] = $item->sortBy('distance');
        //     });

        // dump($orders);
        // dump($stocks);
        // exit;

        return view('orders.lorries', compact('orders', 'stocks', 'filter_date'));
    }

    public function assignDriverOrder(Request $request)
    {
        $order = Order::find($request->id);

        $client = new Client(['base_uri' => 'https://maps.googleapis.com/maps/api/distancematrix/']);
        $element = json_decode(
            $client->get("json?origins=" . $order->user->latitude . "," . $order->user->longitude
                . "&destinations=" . env("WAREHOUSE")
                . "&key=" . env("GMAP_KEY"))
                ->getBody()
        )
            ->rows[0]
            ->elements[0];

        $order->lorry_id = $request->lorry_id;
        $order->distance = isset($element->distance) ? round($element->distance->value / 1000, 2) : "0";
        $order->save();

        return response($order);
    }

    public function updateApproveBuyerOrder(Request $request)
    {
        $order = Order::find($request->id);

        foreach ($order->products as $product) {
            $inStock = false;

            if ($product->pivot->grade === "A") {
                $inventories = Inventory::where([
                    ['product_id', $product->id],
                ])->get();

                if ($inventories->count() > 0) {
                    foreach ($inventories as $inventory) {
                        if ($inventory->totalRemainingActual($product->id) < $product->pivot->quantity) {
                            continue;
                        } else {
                            $inStock = true;
                            break;
                        }
                    }
                }

                if (!$inStock) {
                    return response()->json([
                        "message" => "No stock enough/available for $product->name (Grade A)",
                    ], 404);
                }
            } else if ($product->pivot->grade === "B") {
                $promotions = Promotion::where([
                    ['product_id', $product->id],
                ])->get();

                if ($promotions->count() > 0) {
                    foreach ($promotions as $promotion) {
                        if ($promotion->totalRemaining() < $product->pivot->quantity) {
                            continue;
                        } else {
                            $inStock = true;
                            break;
                        }
                    }
                }

                if (!$inStock) {
                    return response()->json([
                        "message" => "No remaining promotion enough/available for $product->name (Grade B)",
                    ], 404);
                }
            }
        }

        foreach ($order->products as $product) {
            if ($product->pivot->grade === "A") {
                $inventories = Inventory::where([
                    ['product_id', $product->id],
                ])->get();

                if ($inventories->count() > 0) {
                    foreach ($inventories as $inventory) {
                        if ($inventory->totalRemainingActual($product->id) < $product->pivot->quantity) {
                            continue;
                        } else {
                            $product->quantity_a -= $product->pivot->quantity;
                            $order->status = 1;
                            $inventory->orders()->syncWithoutDetaching([$order->id]);

                            break;
                        }
                    }
                }
            } else if ($product->pivot->grade === "B") {
                $promotions = Promotion::where([
                    ['product_id', $product->id],
                ])->get();

                if ($promotions->count() > 0) {
                    foreach ($promotions as $promotion) {
                        if ($promotion->totalRemaining() < $product->pivot->quantity) {
                            continue;
                        } else {
                            $product->quantity_b -= $product->pivot->quantity;
                            $order->status = 1;

                            //$promotion->orders()->syncWithoutDetaching([$order->id]);
                            $promotion->total_sold += $product->pivot->quantity;
                            $promotion->save();

                            break;
                        }
                    }
                }
            }

            $product->save();
        }

        $order->save();
        return response($order);
    }

    public function updateApproveSellerStock(Request $request)
    {
        $stock = Stock::find($request->id);

        foreach ($stock->products as $product) {
            if ($product->pivot->grade === "A") {
                $inventory = Inventory::where([
                    ['product_id', $product->id],
                    ['created_at', '>=', Carbon::today()],
                ])->first();

                if (is_null($inventory)) {
                    $inventory = new Inventory();
                    $inventory->product_id = $product->id;
                    $inventory->price_id = $product->price_latest->id;
                    $inventory->save();

                    $inventory->stocks()->syncWithoutDetaching([$stock->id]);
                } else {
                    $inventory->stocks()->syncWithoutDetaching([$stock->id]);
                }

                $product->quantity_a += $product->pivot->quantity;
            } else if ($product->pivot->grade === "B") {
                $promotion = Promotion::where([
                    ['product_id', $product->id],
                    ['created_at', '>=', Carbon::today()],
                ])->first();

                if (is_null($promotion)) {
                    $promotion = new Promotion();
                    $promotion->product_id = $product->id;
                    $promotion->price = $product->priceValid($stock->created_at)->buyer_price_b;
                    $promotion->buy_at_price = $product->priceValid($stock->created_at)->seller_price_b;
                    $promotion->quantity = $product->pivot->quantity;
                    $promotion->save();

                    // $promotion->stocks()->syncWithoutDetaching([$stock->id]);
                } else {
                    $promotion->quantity += $product->pivot->quantity;
                    // $promotion->stocks()->syncWithoutDetaching([$stock->id]);
                }

                $product->quantity_b += $product->pivot->quantity;
            }

            $product->save();
        }

        $stock->status = 1;
        $stock->save();

        return response($stock);
    }

    public function updateRejectBuyerOrder(Request $request)
    {
        $order = Order::find($request->id);
        $order->status = 2;
        $order->save();

        $feedback = new Feedback();
        $feedback->topic = $request->topic;
        $feedback->description = $request->description;
        $feedback->order()->associate($order);
        $feedback->save();

        return response($order);
    }

    public function updateRejectSellerStock(Request $request)
    {
        $stock = Stock::find($request->id);
        $stock->status = 2;
        $stock->save();

        $feedback = new Feedback();
        $feedback->topic = $request->topic;
        $feedback->description = $request->description;
        $feedback->stock()->associate($stock);
        $feedback->save();

        return response($stock);
    }

    public function updatePendingOrderStock(Request $request)
    {
        if ($request->type === "order") {
            $order = Order::find($request->id);
            $order->status = 1;
            $order->save();
            return response($order);
        } else if ($request->type === "stock") {
            $stock = Stock::find($request->id);
            $stock->status = 1;
            $stock->save();
            return response($stock);
        }
    }

    public function updatePayment(Request $request)
    {
        if ($request->type === "order") {
            $order = Order::find($request->id);
            $order->status = $request->status;
            $order->save();

            return response($order);
        } else if ($request->type === "stock") {
            $stock = Stock::find($request->id);
            $stock->status = $request->status;
            $stock->save();

            return response($stock);
        }
    }

    public function updateCompleteOrderStock(Request $request)
    {
        if ($request->type === "order") {
            $order = Order::find($request->id);
            $order->status = 3;
            $order->save();
            return response($order);
        } else if ($request->type === "stock") {
            $stock = Stock::find($request->id);
            $stock->status = 3;
            $stock->save();
            return response($stock);
        }
    }

    public function show(Request $request, $order_id)
    {
        $order = Order::find($order_id);

        return response()->json([
            'data' => $order->products()->getFullByDate($order->created_at),
        ]);
    }

    public function editBuyer(Request $request, $id)
    {
        $order = Order::find($id);
        return view('orders.buyers.edit', compact('order'));
    }

    public function editSeller(Request $request, $id)
    {
        $stock = Stock::find($id);
        return view('orders.sellers.edit', compact('stock'));
    }

    public function updateBuyer(Request $request, $id)
    {
        $order = Order::find($id);
        $order->products()->detach();

        for ($x = 0; $x < count($request->input('id')); $x++) {
            $product = Product::find($request->input('id')[$x]);
            $order->products()->save($product, [
                'quantity' => $request->input('quantity')[$x],
                'grade' => $request->input('grade')[$x],
            ]);
        }

        $order->save();

        return redirect()->route('orders.index.receipts');
    }

    public function updateSeller(Request $request, $id)
    {
        $stock = Stock::find($id);
        $stock->products()->detach();

        for ($x = 0; $x < count($request->input('id')); $x++) {
            $product = Product::find($request->input('id')[$x]);
            $stock->products()->save($product, [
                'quantity' => $request->input('quantity')[$x],
                'grade' => $request->input('grade')[$x],
            ]);
        }

        $stock->save();

        return redirect()->route('orders.index.receipts');
    }

    public function delete($order_id, Request $request)
    {
        $order = Order::find($order_id);
        $order->delete();
        Session::flash('message', 'Successfully deleted!');
        return Redirect::to('driver');
    }
}
