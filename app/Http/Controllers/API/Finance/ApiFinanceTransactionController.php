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

    // Query Pengeluaran perhari dari datenow ke akhir bulan bulan ini . bagi dengan finance account
    public function getDailyExpensesByAccount()
    {
        $accounts = FinanceAccount::where('bank_name', 'BCA')->get();

        $today = now();
        $maxDate = now()->copy()->day(27); // batas tanggal 27

        $availableDays = [];
        $date = $today->copy();

        // Loop hanya sampai tanggal 27
        while ($date->lte($maxDate)) {

            if ($date->isWeekday()) {
                $availableDays[] = [
                    'tanggal' => $date->toDateString(),
                    'hari' => $date->translatedFormat('l'),
                ];
            }

            $date->addDay();
        }

        $workingDays = count($availableDays);

        $result = $accounts->map(function ($account) use ($workingDays, $availableDays) {

            $balance = $account->balance ?? 0;

            $maxExpensePerDay = $workingDays > 0
                ? round($balance / $workingDays, 2)
                : 0;

            return [
                'account_id' => $account->id,
                'account_name' => $account->bank_name,
                'balance' => $balance,
                'working_days' => $workingDays,
                'available_days' => $availableDays,
                'max_expense_per_day' => $maxExpensePerDay,
            ];
        });

        return response()->json($result);
    }
}
