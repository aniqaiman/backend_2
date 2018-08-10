<?php

namespace App\Http\Controllers;

use App\LorryCapacity;
use App\LorryType;
use App\User;
use Illuminate\Http\Request;
use Redirect;
use Session;

class DriverController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $driver = new User;

        $driver->name = $request->name;
        $driver->company_registration_mykad_number = $request->company_registration_mykad_number;
        $driver->address = $request->address;
        $driver->phone_number = $request->phone_number;
        $driver->driver_license_number = $request->driver_license_number;
        $driver->lorry_roadtax_expiry = $request->lorry_roadtax_expiry;
        $driver->lorry_type_id = $request->lorry_type_id;
        $driver->lorry_capacity_id = $request->lorry_capacity_id;
        $driver->lorry_plate_number = $request->lorry_plate_number;
        $driver->location_covered = $request->location_covered;
        $driver->password = bcrypt($request->password);
        $driver->status_email = 1;
        $driver->status_account = 1;
        $driver->group_id = 31;
        // $driver->bank_name = $request->bank_name;
        // $driver->bank_acc_holder_name = $request->bank_acc_holder_name;
        // $driver->bank_acc_number = $request->bank_acc_number;

        if ($request->hasFile('driver_license_picture')) {
            $awspath = $request->file('driver_license_picture')->store('public/images');
            $driver->driver_license_picture = $awspath;
        }

        $driver->save();
        return redirect()->route('users.drivers.create')->with('success', 'New driver had been added.');
    }

    public function index()
    {
        $drivers = User::where('group_id', 31)->get();
        $types = LorryType::all();
        $capacities = LorryCapacity::all();
        return view('driver.driver', compact('drivers', 'types', 'capacities'));
    }

    public function create()
    {
        $lorry_types = LorryType::all();
        $lorry_capacities = LorryCapacity::all();
        return view('drivers.create', compact('lorry_types', 'lorry_capacities'));
    }

    public function edit($user_id, Request $request)
    {
        $drivers = User::where('user_id', $user_id)->first();
        $types = Type::all();
        $capacities = Capacity::all();
        return view('driver.editDriver', compact('drivers', 'types', 'capacities'));
    }

    public function update(Request $request)
    {
        $path = $request->file('drivers_license')->store('public/images');
        if ($request->ajax()) {
            $drivers = User::where('user_id', $request->user_id)->first();
            $drivers->name = $request->name;
            $drivers->company_reg_ic_number = $request->company_reg_ic_number;
            $drivers->address = $request->address;
            $drivers->phonenumber = $request->phonenumber;
            $drivers->license_number = $request->license_number;
            $drivers->drivers_license = $path;
            $drivers->roadtax_expiry = $request->roadtax_expiry;
            $drivers->type_of_lorry = $request->type_of_lorry;
            $drivers->lorry_capacity = $request->lorry_capacity;
            $drivers->location_to_cover = $request->location_to_cover;
            $drivers->lorry_plate_number = $request->lorry_plate_number;
            $drivers->bank_name = $request->bank_name;
            $drivers->bank_acc_holder_name = $request->bank_acc_holder_name;
            $drivers->bank_acc_number = $request->bank_acc_number;
            $drivers->password = bcrypt('$request->password');
            $drivers->save();
            return response($drivers);
        }
    }

    public function delete($user_id, Request $request)
    {
        $drivers = User::find($user_id);
        $drivers->delete();
        Session::flash('message', 'Successfully deleted!');
        return Redirect::to('driver');
    }

    public function show($user_id, Request $request)
    {
        $driver = User::where('user_id', $user_id)->first();
        $types = Type::all();
        $capacities = Capacity::all();
        return view('driver.driverdetail', compact('driver', 'types', 'capacities'));
    }
}
