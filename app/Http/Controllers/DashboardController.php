<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Finance\FinanceAccount;
use App\Models\Finance\FinanceDailyBalance;
use App\Models\Finance\FinanceWeeklyBalance;
use App\Models\Finance\FinanceYearlyBalance;
use App\Models\Finance\FinanceMonthlyBalance;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        //  ========================= Total Balance ==========================//
        $totalBalance = FinanceAccount::sum('balance');

        //  ========================= Income Monthly ==========================//
        $incomeMonth = FinanceMonthlyBalance::where('year', date('Y'))
            ->where('month', date('m'))
            ->sum('income_total');

        // ========================== Income Growth ==========================// 
        $currentYear = (int) date('Y');
        $currentMonth = (int) date('m');
        if ($currentMonth === 1) {
            $lastMonth = 12;
            $lastYear = $currentYear - 1;
        } else {
            $lastMonth = $currentMonth - 1;
            $lastYear = $currentYear;
        }

        $incomeLastMonth = FinanceMonthlyBalance::where('year', $lastYear)
            ->where('month', str_pad($lastMonth, 2, '0', STR_PAD_LEFT))
            ->sum('income_total');
        if ($incomeLastMonth == 0) {
            $incomeGrowth = $incomeMonth > 0 ? 100.0 : 0.0;
        } else {
            $incomeGrowth = round((($incomeMonth - $incomeLastMonth) / $incomeLastMonth) * 100, 2);
        }

        // ========================== Expense Monthly ==========================//
        $expenseMonth = FinanceMonthlyBalance::where('year', date('Y'))
            ->where('month', date('m'))
            ->sum('expense_total');

        // ========================== Expense Growth ==========================// 
        $expenseLastMonth = FinanceMonthlyBalance::where('year', $lastYear)
            ->where('month', str_pad($lastMonth, 2, '0', STR_PAD_LEFT))
            ->sum('expense_total');
        if ($expenseLastMonth == 0) {
            $expenseGrowth = $expenseMonth > 0 ? 100.0 : 0.0;
        } else {
            $expenseGrowth = round((($expenseMonth - $expenseLastMonth) / $expenseLastMonth) * 100, 2);
        }

        //========================== Net Flow ==========================// 
        $netFlow = $incomeMonth - $expenseMonth;

        //========================== Line Chart Data ==========================// 
        $currentYear = now()->year;
        $balances = FinanceMonthlyBalance::where('year', $currentYear)
            ->get(['month', 'income_total', 'expense_total'])
            ->keyBy('month');
        $chartLabels = [];
        $chartIncome = [];
        $chartExpense = [];
        // Loop 1–12 (bulan penuh)
        for ($month = 1; $month <= 12; $month++) {
            $chartLabels[] = Carbon::create()->month($month)->format('M');
            $chartIncome[] = isset($balances[$month]) ? (float) $balances[$month]->income_total : 0;
            $chartExpense[] = isset($balances[$month]) ? (float) $balances[$month]->expense_total : 0;
        }


        // ====== Render ke view
        return view('layouts.app', [
            'content' => view('pages.dashboard', compact(
                'totalBalance',
                'incomeGrowth',
                'incomeMonth',
                'expenseGrowth',
                'expenseMonth',
                'netFlow',
                'chartLabels',
                'chartIncome',
                'chartExpense'
            ))->render()
        ]);
    }
}
