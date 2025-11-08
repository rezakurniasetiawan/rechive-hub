<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Finance\{
    FinanceAccount,
    FinanceDailyBalance,
    FinanceWeeklyBalance,
    FinanceYearlyBalance,
    FinanceMonthlyBalance,
    FinanceTransaction
};

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $currentDate  = now();
        $currentYear  = $currentDate->year;
        $currentMonth = $currentDate->month;

        // ========================= Total Balance ========================== //
        $totalBalance = FinanceAccount::sum('balance');

        // ========================= Income & Expense (Current Month) ========================== //
        $monthlyBalance = FinanceMonthlyBalance::where('year', $currentYear)
            ->where('month', str_pad($currentMonth, 2, '0', STR_PAD_LEFT))
            ->first();

        $incomeMonth  = $monthlyBalance->income_total  ?? 0;
        $expenseMonth = $monthlyBalance->expense_total ?? 0;

        // ========================= Previous Month ========================== //
        $lastMonth = $currentMonth === 1 ? 12 : $currentMonth - 1;
        $lastYear  = $currentMonth === 1 ? $currentYear - 1 : $currentYear;

        $lastMonthlyBalance = FinanceMonthlyBalance::where('year', $lastYear)
            ->where('month', str_pad($lastMonth, 2, '0', STR_PAD_LEFT))
            ->first();

        $incomeLastMonth  = $lastMonthlyBalance->income_total  ?? 0;
        $expenseLastMonth = $lastMonthlyBalance->expense_total ?? 0;

        // ========================= Growth Calculations ========================== //
        $incomeGrowth  = $this->calculateGrowth($incomeMonth, $incomeLastMonth);
        $expenseGrowth = $this->calculateGrowth($expenseMonth, $expenseLastMonth);

        // ========================= Net Flow & Growth ========================== //
        $netFlow       = $incomeMonth - $expenseMonth;
        $netFlowLast   = $incomeLastMonth - $expenseLastMonth;
        $netFlowGrowth = $this->calculateGrowth($netFlow, $netFlowLast);

        // ========================= Line Chart Data (Full Year) ========================== //
        $balances = FinanceMonthlyBalance::where('year', $currentYear)
            ->get(['month', 'income_total', 'expense_total'])
            ->keyBy('month');

        $chartLabels  = [];
        $chartIncome  = [];
        $chartExpense = [];

        for ($month = 1; $month <= 12; $month++) {
            $chartLabels[]  = Carbon::create()->month($month)->format('M');
            $chartIncome[]  = (float) ($balances[$month]->income_total  ?? 0);
            $chartExpense[] = (float) ($balances[$month]->expense_total ?? 0);
        }

        // ========================= Bar Chart Data (Current Month by Date) ========================== //
        $dailyBalances = FinanceDailyBalance::whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonth)
            ->get(['date', 'income_total', 'expense_total'])
            ->keyBy(fn($item) => Carbon::parse($item->date)->day);

        $daysInMonth = $currentDate->daysInMonth;
        $barLabels   = [];
        $barIncome   = [];
        $barExpense  = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $barLabels[]  = str_pad($day, 2, '0', STR_PAD_LEFT);
            $barIncome[]  = (float) ($dailyBalances[$day]->income_total  ?? 0);
            $barExpense[] = (float) ($dailyBalances[$day]->expense_total ?? 0);
        }

        // ========================= Last 5 Transactions ========================== //
        $lastTransaction = FinanceTransaction::with([
            'financeAccount:id,bank_name,logo',
            'financeCategory:id,name',
            'financeType:id,name,label'
        ])
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // ========================= Expense by Category (Pie Chart) ========================== //
        $expenseByCategoryData = FinanceTransaction::selectRaw('finance_category_id, SUM(amount) as total_expense')
            ->where('finance_type_id', 2) // 2 = Expense
            ->whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonth)
            ->groupBy('finance_category_id')
            ->with('financeCategory:id,name,color')
            ->get();

        $expenseLabels = $expenseByCategoryData->map(function ($item) {
            return optional($item->financeCategory)->name ?? 'Tanpa Kategori';
        })->toArray();

        $expenseData = $expenseByCategoryData->map(function ($item) {
            return (float) $item->total_expense;
        })->toArray();

        $expenseColors = $expenseByCategoryData->map(function ($item) {
            return optional($item->financeCategory)->color ?? '#CCCCCC';
        })->toArray();


        // Today's expenses transaction excluded length
        $todayExpensesCount = FinanceTransaction::where('finance_type_id', 2)
            ->whereDate('date', $currentDate->toDateString())
            ->count();

        $todayExpensesTotal = FinanceTransaction::where('finance_type_id', 2)
            ->whereDate('date', $currentDate->toDateString())
            ->sum('amount');

        // Month Excluded length
        $monthExpensesCount = FinanceTransaction::where('finance_type_id', 2)
            ->whereMonth('date', $currentMonth)
            ->count();


        // ========================= Render View ========================== //
        return view('layouts.app', [
            'content' => view('pages.dashboard', compact(
                'totalBalance',
                'incomeMonth',
                'incomeGrowth',
                'expenseMonth',
                'expenseGrowth',
                'netFlow',
                'netFlowGrowth',
                'expenseLastMonth',
                'chartLabels',
                'chartIncome',
                'chartExpense',
                'barLabels',
                'barIncome',
                'barExpense',
                'lastTransaction',
                'expenseLabels',
                'expenseData',
                'expenseColors',
                'todayExpensesCount',
                'monthExpensesCount',
                'todayExpensesTotal'
            ))->render()
        ]);
    }

    /**
     * Hitung pertumbuhan (growth) dalam persen.
     */
    private function calculateGrowth(float $current, float $previous): float
    {
        if ($previous == 0) {
            return $current > 0 ? 100.0 : 0.0;
        }

        return round((($current - $previous) / $previous) * 100, 2);
    }
}
