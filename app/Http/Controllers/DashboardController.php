<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getDashboard(Request $request)
    {
        return view('dashboard');
    }
}
