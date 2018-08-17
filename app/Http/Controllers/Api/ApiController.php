<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use JWTAuth;

class ApiController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only('company_registration_mykad_number', 'password');
        $token = null;
   
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'message' => 'Invalid (company registration / MyKad) number or password',
                ], 401);
            }

            $credentials['status_email'] = 1;

            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'message' => 'Your account is not verified yet. Please check your email to verify it.',
                ], 401);
            }

            $credentials['status_account'] = 1;

            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'message' => 'Your account is not verified yet. It is currently being reviewed. You will be contacted by foodrico soon.',
                ], 401);
            }

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to generate token.',
            ], 500);
        }

        $user = auth()->user();
        $user["group"] = $user->group;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function getAuthUser(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $user["group"] = $user->group;

            return response()->json([
                "data" => $user,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to verify token.',
            ], 500);
        }
    }

    public function verifyReCAPTCHA(Request $request)
    {
        $client = new Client();
        $response = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => '6Lf7CmoUAAAAAHBFXm7UIHgBluXT7PutCBUc3rf4',
                'response' => $request->input('captcha'),
            ],
        ]);

        return response()->json(
            json_decode($response->getBody()),
            $response->getStatusCode()
        );
    }

    public function verifyUserEmail($token)
    {
        $user = User::find(Crypt::decryptString($token));
        $user->status_email = 1;
        $user->save();

        return response($user);
    }

    public function playground(Request $request)
    {
        return response()->json(
            \App\Category::with('products', 'products.prices')->find('1')->toArray()
        );
    }

}
