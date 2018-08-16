<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use JWTAuth;
use Mail;
use Carbon\Carbon;
use Storage;
use Image;

class SellerController extends Controller
{
    public function store(Request $request)
    {
        if (User::where('company_registration_mykad_number', $request->input('company_registration_mykad_number'))->exists()) {
            return response()->json([
                'message' => 'The (company registration / MyKad) number had been used.',
            ], 403);
        }

        if (User::where('email', $request->input('email'))->exists()) {
            return response()->json([
                'message' => 'The email had been used.',
            ], 403);
        }

        $seller = User::create([
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
            'status_email' => 0,
            'status_account' => 0,
        ]);

        $seller->activation_token = Crypt::encryptString($seller->id);

        Mail::send('email.registration_sucess', ['user' => $seller], function ($message) use ($seller) {

            $message->subject('FoodRico Registration - Account Verification');
            $message->from('wanmuz.ada@gmail.com', 'FoodRico Notification');
            $message->to($seller->email);

        });

        return response()->json([
            "data" => $seller,
        ]);
    }

    public function update(Request $request)
    {
        $seller = JWTAuth::parseToken()->authenticate();
        $imagePath = $seller->display_picture;

        if ($seller->company_registration_mykad_number !== $request->company_registration_mykad_number
            && User::where('company_registration_mykad_number', $request->company_registration_mykad_number)->exists()) {
            return response()->json([
                'message' => 'The (company registration / MyKad) number had been used.',
            ], 403);
        }

        if ($seller->email !== $request->email
            && User::where('email', $request->email)->exists()) {
            return response()->json([
                'message' => 'The email had been used.',
            ], 403);
        }

        if ($request['display_picture'] != "") {
            Storage::delete($seller->display_picture);
            $filename = 'image_'.str_replace(' ', '', $request['name']).'_'.Carbon::now().'.jpg';
            $sellerImagePath = 'seller-image/' . $filename;
            $image_seller = Image::make($request->display_picture)->orientate()->fit(500);
            $image_seller = $image_seller->stream();
            Storage::disk('s3')->put($sellerImagePath, $image_seller->__toString());
            $imagePath = $sellerImagePath;
        } 

        $seller->name = $request->name;
        $seller->company_name = $request->company_name;
        $seller->company_registration_mykad_number = $request->company_registration_mykad_number;
        $seller->address = $request->address;
        $seller->latitude = $request->latitude;
        $seller->longitude = $request->longitude;
        $seller->mobile_number = $request->mobile_number;
        $seller->email = $request->email;
        $seller->bank_name = $request->bank_name;
        $seller->bank_account_holder_name = $request->bank_account_holder_name;
        $seller->bank_account_number = $request->bank_account_number;
        $seller->display_picture = env('APP_PHOTO_URL').$imagePath;
        $seller->profile_verified = 1;
        $seller->save();

        return response()->json([
            "data" => $seller,
        ]);
    }

    public function getSellers(Request $request)
    {
        $sellers = User::where('group_id', 21)->get();

        $sellerArray = [];

        foreach ($sellers as $seller) {
            $newseller["user_id"] = $seller->user_id;
            $newseller["name"] = $seller->name;
            $newseller["company_name"] = $seller->company_name;
            $newseller["company_reg_ic_number"] = $seller->company_reg_ic_number;
            $newseller["address"] = $seller->address;
            $newseller["latitude"] = $seller->latitude;
            $newseller["longitude"] = $seller->longitude;
            $newseller["handphone_number"] = $seller->handphone_number;
            $newseller["email"] = $seller->email;
            $newseller["group_id"] = $seller->group_id;

            array_push($sellerArray, $newseller);
        }

        return response()->json(['data' => $sellerArray, 'status' => 'ok']);
    }

    public function getSeller($user_id, Request $request)
    {
        $seller = User::where('user_id', $user_id)->first();

        $newseller["user_id"] = $seller->user_id;
        $newseller["name"] = $seller->name;
        $newseller["company_name"] = $seller->company_name;
        $newseller["company_reg_ic_number"] = $seller->company_reg_ic_number;
        $newseller["address"] = $seller->address;
        $newseller["latitude"] = $seller->latitude;
        $newseller["longitude"] = $seller->longitude;
        $newseller["handphone_number"] = $seller->handphone_number;
        $newseller["email"] = $seller->email;
        $newseller["group"] = $seller->groups->group_name;

        return response()->json(['data' => $newseller, 'status' => 'ok']);
    }
}
