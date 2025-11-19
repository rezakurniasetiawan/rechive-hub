<?php

namespace App\Http\Controllers\API\Finance;

use Illuminate\Http\Request;
use App\Models\Finance\FinanceType;
use App\Http\Controllers\Controller;
use App\Models\Finance\FinanceAccount;
use App\Models\Finance\FinanceCategory;

class ApiFinanceTransactionController extends Controller
{
    public function getFinanceTypes()
    {
        $data = FinanceType::whereRaw('LOWER(name) IN (?, ?)', ['income', 'expense'])->get();
        return response()->json($data);
    }

    public function getFinanceAccounts()
    {
        $data = FinanceAccount::all();
        return response()->json($data);
    }

    public function getFinanceCategories()
    {
        $data = FinanceCategory::inRandomOrder()->get();
        return response()->json($data);
    }
}
