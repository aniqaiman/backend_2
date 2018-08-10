<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Mail;

class DriverController extends Controller
{
    public function store(Request $request)
    {
        if (User::where('company_registration_mykad_number', $request->input('company_registration_mykad_number'))->exists()) {
            return response()->json([
                'message' => 'The MyKad number had been used.',
            ], 403);
        }

        if (User::where('email', $request->input('email'))->exists()) {
            return response()->json([
                'message' => 'The email had been used.',
            ], 403);
        }

        $driver = User::create([
            'name' => $request->input('name'),
            'company_registration_mykad_number' => $request->input('company_registration_mykad_number'),
            'address' => $request->input('address'),
            'phone_number' => $request->input('phone_number'),
            'driver_license_number' => $request->input('driver_license_number'),
            'driver_license_picture' => $request->input('driver_license_picture'),
            'lorry_roadtax_expiry' => $request->input('lorry_roadtax_expiry'),
            'lorry_type_id' => $request->input('lorry_type_id'),
            'lorry_capacity_id' => $request->input('lorry_capacity_id'),
            'lorry_plate_number' => $request->input('lorry_plate_number'),
            'state_id' => 0,
            'group_id' => 31,
        ]);

        return response()->json([
            "data" => $driver,
        ]);
    }
}
