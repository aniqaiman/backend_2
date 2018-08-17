<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use JWTAuth;
use DB;

class SupplyController extends Controller
{
    public function getSupplies()
    {
        return response()->json([
            'data' => JWTAuth::parseToken()->authenticate()
                ->supplies()
                ->with('category')
                ->get(),
        ]);
    }

    public function postSupplies(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $user->supplies()->detach();

         $supplies = $request["supplies"];

            foreach ($supplies as $supply) 
            {
                $newSupply = DB::table('supplies')->insert([
                    'product_id' => $supply["product_id"],
                    'harvesting_period_start' => Carbon::parse($supply["harvesting_period_start"], 'UTC')->setTimezone('Asia/Kuala_Lumpur'),
                    'harvesting_period_end' => Carbon::parse($supply["harvesting_period_end"], 'UTC')->setTimezone('Asia/Kuala_Lumpur'),
                    'harvest_frequency' => $supply["harvest_frequency"],
                    'total_plants' => $supply["total_plants"],
                    'total_farm_area' => $supply["total_farm_area"],
                    'user_id' => $user->id
                ]);
            }

        return response()->json([
            "data" => $user->supplies,
        ]);
    }
}
