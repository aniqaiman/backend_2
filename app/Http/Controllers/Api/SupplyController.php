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

        foreach ($request->all() as $supply) {
            $user->supplies()->syncWithoutDetaching([$supply["product"]["id"] => [
                'harvesting_period_start' => Carbon::parse($supply["harvestingPeriodStart"], 'UTC')->setTimezone('Asia/Kuala_Lumpur'),
                'harvesting_period_end' => Carbon::parse($supply["harvestingPeriodEnd"], 'UTC')->setTimezone('Asia/Kuala_Lumpur'),
                'harvest_frequency' => $supply["harvestFrequency"],
                'total_plants' => $supply["totalPlants"],
                'total_farm_area' => $supply["totalFarmArea"],
            ]]);
        }

        return response()->json([
            "data" => $user->supplies,
        ]);
    }
}
