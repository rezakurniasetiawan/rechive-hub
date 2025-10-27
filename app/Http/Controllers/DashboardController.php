<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        return view('layouts.app', [
            'content' => view('pages.dashboard')->render()
        ]);
    }
}
