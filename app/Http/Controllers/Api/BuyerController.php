<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use JWTAuth;
use Mail;

class BuyerController extends Controller
{
    public function store(Request $request)
    {
        if (User::where('company_registration_mykad_number', $request->company_registration_mykad_number)->exists()) {
            return response()->json([
                'message' => 'The (company registration / MyKad) number had been used.',
            ], 403);
        }

        if (User::where('email', $request->email)->exists()) {
            return response()->json([
                'message' => 'The email had been used.',
            ], 403);
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
            'status_email' => 0,
            'status_account' => 0,
        ]);

        $buyer->activation_token = Crypt::encryptString($buyer->id);

        Mail::send('email.registration_sucess', ['user' => $buyer], function ($message) use ($buyer) {

            $message->subject('FoodRico Registration - Account Verification');
            $message->from('wanmuz.ada@gmail.com', 'FoodRico Notification');
            $message->to($buyer->email);

        });

        return response()->json([
            "data" => $buyer,
        ]);
    }

    public function update(Request $request)
    {
        $buyer = JWTAuth::parseToken()->authenticate();

        if ($buyer->company_registration_mykad_number !== $request->company_registration_mykad_number
            && User::where('company_registration_mykad_number', $request->company_registration_mykad_number)->exists()) {
            return response()->json([
                'message' => 'The (company registration / MyKad) number had been used.',
            ], 403);
        }

        if ($buyer->email !== $request->email
            && User::where('email', $request->email)->exists()) {
            return response()->json([
                'message' => 'The email had been used.',
            ], 403);
        }

        if($request->display_picture)
        {
            $filename = $buyer->id . '-' . substr(md5($buyer->id . '-' . time()), 0, 15) . '.jpg';

            $path = 'public/images/' . $filename;

            $image_normal = Image::make($request->display_picture)->orientate()->fit(500);
            $image_normal = $image_normal->stream();
            
            Storage::disk('s3')->put($path, $image_normal->__toString());

            $buyer->display_picture = $path;
            $buyer->profile_verified = 1;
        }

        $buyer->name = $request->name;
        $buyer->company_name = $request->company_name;
        $buyer->company_registration_mykad_number = $request->company_registration_mykad_number;
        $buyer->bussiness_hour = $request->bussiness_hour;
        $buyer->address = $request->address;
        $buyer->latitude = $request->latitude;
        $buyer->longitude = $request->longitude;
        $buyer->mobile_number = $request->mobile_number;
        $buyer->phone_number = $request->phone_number;
        $buyer->email = $request->email;
        $buyer->save();

        return response()->json([
            "data" => $buyer,
        ]);
    }

    public function getBuyers(Request $request)
    {
        return response()->json([
            "data" => User::select(
                'id',
                'name',
                'company_name',
                'company_registration_mykad_number',
                'bussiness_hour',
                'address',
                'latitude',
                'longitude',
                'mobile_number',
                'phone_number',
                'email'
            )
                ->where('group_id', 11)
                ->get(),
        ]);
    }

    public function getBuyer($user_id, Request $request)
    {
        return response()->json([
            "data" => User::select(
                'id',
                'name',
                'company_name',
                'company_registration_mykad_number',
                'bussiness_hour',
                'address',
                'latitude',
                'longitude',
                'mobile_number',
                'phone_number',
                'email'
            )
                ->find($user_id),
        ]);
    }
}
