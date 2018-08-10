<?php

namespace App\Http\Controllers;

use App\Product;
use App\User;
use Illuminate\Http\Request;
use Redirect;
use Session;

class BuyerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        if (User::where('company_registration_mykad_number', $request->input('company_registration_mykad_number'))->exists()) {
            return redirect()->route('users.buyers.create')->with('error', 'The (company registration / MyKad) number had been used.');
        }

        if (User::where('email', $request->input('email'))->exists()) {
            return redirect()->route('users.buyers.create')->with('error', 'The email had been used.');
        }

        $buyer = User::create([
            'name' => $request->name,
            'company_name' => $request->company_name,
            'company_registration_mykad_number' => $request->company_registration_mykad_number,
            'bussiness_hour' => $request->bussiness_hour,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'mobile_number' => $request->mobile_number,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'group_id' => 11,
            'status_email' => 1,
            'status_account' => 1,
        ]);

        return redirect()->route('users.buyers.create')->with('success', 'New buyer had been added.');
    }

    public function index()
    {
        $buyers = User::orderBy('active_counter', 'desc')
            ->where('group_id', 11)
            ->get()
            ->each(function ($buyer) {
                $buyer->products = Product::orderBy('active_counter', 'asc')
                    ->whereHas('orders', function ($order) use ($buyer) {
                        $order->where('user_id', $buyer->id);
                    })->get();
            });

        $activated_buyers = $buyers->where('status_account', 1);
        $deactivated_buyers = $buyers->where('status_account', 0);
        
        return view('buyers.index', compact('buyers', 'activated_buyers', 'deactivated_buyers'));
    }

    public function create(Request $request)
    {
        return view('buyers.create');
    }

    public function edit($user_id, Request $request)
    {
        $buyers = User::where('user_id', $user_id)->first();
        return view('buyer.editBuyer', compact('buyers'));
    }

    public function update(Request $request)
    {
        if ($request->ajax()) {
            $buyers = User::where('user_id', $request->user_id)->first();
            $buyers->name = $request->name;
            $buyers->company_name = $request->company_name;
            $buyers->company_reg_ic_number = $request->company_reg_ic_number;
            $buyers->buss_hour = $request->buss_hour;
            $buyers->address = $request->address;
            $buyers->phonenumber = $request->phonenumber;
            $buyers->handphone_number = $request->handphone_number;
            $buyers->email = $request->email;
            $buyers->password = bcrypt('$request->password');
            $buyers->save();
            return response($buyers);
        }
    }

    public function delete($user_id, Request $request)
    {
        $buyers = User::find($user_id);
        $buyers->delete();
        Session::flash('message', 'Successfully deleted!');
        return Redirect::to('buyer');
    }
}
