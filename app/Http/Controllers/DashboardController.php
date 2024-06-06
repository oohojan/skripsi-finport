<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function dash_owner()
    {
        return view('dashboard_owner');
    }

    public function dash_emp()
    {
        return view('dashboard_emp');
    }
}
