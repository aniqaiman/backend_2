<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Auth;
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getDashboard(Request $request)
    {
    	Auth::user();

    	if (Auth::user()->group_id == 11 || Auth::user()->group_id == 21) 
    	{
    		return redirect('http://member.foodrico.com/');
    	}
    	
        return view('dashboard');
    }
}
