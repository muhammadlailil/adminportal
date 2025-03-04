<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        view()->share([
            'breadcrumb' => breadcrumb(),
        ]);
    }
    public function index(Request $request)
    {
        return view('admin.dashboard');
    }

}
