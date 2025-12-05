<?php

namespace App\Http\Controllers\Budget;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    // index
    public function index()
    {
        return view('layouts.app', [
            'content' => view('pages.budgets.budget')->render()
        ]);
    }
}