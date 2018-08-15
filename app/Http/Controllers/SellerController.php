<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Redirect;
use Session;

class SellerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        if (User::where('company_registration_mykad_number', $request->input('company_registration_mykad_number'))->exists()) {
            return redirect()->route('users.sellers.create')->with('error', 'The (company registration / MyKad) number had been used.');
        }

        if (User::where('email', $request->input('email'))->exists()) {
            return redirect()->route('users.sellers.create')->with('error', 'The email had been used.');
        }

        $buyer = User::create([
            'name' => $request->input('name'),
            'company_name' => $request->input('company_name'),
            'company_registration_mykad_number' => $request->company_registration_mykad_number,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'mobile_number' => $request->mobile_number,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'bank_name' => $request->bank_name,
            'bank_account_holder_name' => $request->bank_account_holder_name,
            'bank_account_number' => $request->bank_account_number,
            'group_id' => 21,
            'status_email' => 1,
            'status_account' => 1,
        ]);

        return redirect()->route('users.sellers.create')->with('success', 'New supplier had been added.');
    }

    public function index()
    {
        $sellers = User::orderBy('active_counter', 'desc')
            ->where('group_id', 21)
            ->get();

        $activated_sellers = $sellers->where('status_account', 1);
        $deactivated_sellers = $sellers->where('status_account', 0);

        return view('sellers.index', compact('sellers', 'activated_sellers', 'deactivated_sellers'));
    }

    public function create()
    {
        return view('sellers.create');
    }

    public function edit($user_id)
    {
        $sellers = User::find($user_id);
        return view('sellers.edit', compact('sellers'));
    }

    public function update($user_id, Request $request)
    {
        $sellers = User::find($user_id);

        if ($request->hasFile('display_picture')) {
            Storage::delete($sellers->display_picture);
            $path = $request->file('display_picture')->store('public/images');
            $sellers->display_picture = $path; 
        }
            $sellers->name = $request->name;
            $sellers->company_name = $request->company_name;
            $sellers->company_registration_mykad_number = $request->company_registration_mykad_number;
            $sellers->address = $request->address;
            $sellers->latitude = $request->latitude;
            $sellers->longitude = $request->longitude;
            $sellers->mobile_number = $request->mobile_number;
            $sellers->email = $request->email;
            $sellers->bank_name = $request->bank_name;
            $sellers->bank_account_holder_name = $request->bank_account_holder_name;
            $sellers->bank_account_number = $request->bank_account_number;
            $sellers->save();
            
            return redirect()->route('users.sellers.index')->with('success', 'Supplier info had been updated.');
    }

    public function delete(Request $request, $user_id)
    {
        $sellers = User::find($user_id);
        $sellers->delete();
        Session::flash('message', 'Successfully deleted');
        return Redirect::to('seller');
    }

    public function show(Request $request, $user_id)
    {
        $seller = User::find($user_id);
        return view('sellers.show', compact('seller'));
    }
}
