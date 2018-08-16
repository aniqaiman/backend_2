<?php

namespace App\Http\Controllers;

use App\Product;
use App\User;
use Illuminate\Http\Request;
use App\Status;
use Illuminate\Support\Facades\Storage;
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

    public function edit($user_id)
    {
        $buyers = User::find($user_id);
        $status = Status::all();
        return view('buyers.edit', compact('buyers','status'));
    }

    public function update($user_id, Request $request)
    {
        $buyers = User::find($user_id);

        if ($request->hasFile('display_picture')) {
            Storage::delete($buyers->display_picture);
            $path = $request->file('display_picture')->store('public/images');
            $buyers->display_picture = $path; 
        }
            $buyers->name = $request->name;
            $buyers->company_name = $request->company_name;
            $buyers->company_registration_mykad_number = $request->company_registration_mykad_number;
            $buyers->bussiness_hour = $request->bussiness_hour;
            $buyers->address = $request->address;
            $buyers->latitude = $request->latitude;
            $buyers->longitude = $request->longitude;
            $buyers->mobile_number = $request->mobile_number;
            $buyers->phone_number = $request->phone_number;
            $buyers->email = $request->email;
            $buyers->profile_verified = $request->profile_verified;
            $buyers->save();

            return redirect()->route('users.buyers.index')->with('success', 'Buyer info had been updated.');
        
    }

    public function delete($user_id, Request $request)
    {
        $buyers = User::find($user_id);
        $buyers->delete();
        Session::flash('message', 'Successfully deleted!');
        return Redirect::to('buyer');
    }
}
