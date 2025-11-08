<?php

namespace App\Http\Controllers\Finance;

use Illuminate\Http\Request;
use App\Models\Finance\FinanceType;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Finance\FinanceAccount;
use App\Models\Finance\FinanceCategory;
use App\Models\Finance\FinanceTransaction;
use App\Models\Finance\FinanceDailyBalance;
use App\Models\Finance\FinanceWeeklyBalance;
use App\Models\Finance\FinanceYearlyBalance;
use App\Models\Finance\FinanceMonthlyBalance;

class FinanceTransactionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category');

        // Ambil semua kategori untuk dropdown filter
        $categories = FinanceCategory::all();

        // Query utama FinanceTransaction
        $data = FinanceTransaction::with([
            'financeAccount:id,bank_name,logo',
            'financeCategory:id,name',
            'financeType:id,name,label'
        ])
            ->when($search, function ($query, $search) {
                // Group agar OR tidak keluar dari konteks utama
                $query->where(function ($q) use ($search) {
                    $q->whereHas('financeAccount', function ($sub) use ($search) {
                        $sub->where('bank_name', 'like', "%{$search}%");
                    })
                        ->orWhereHas('financeCategory', function ($sub) use ($search) {
                            $sub->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('financeType', function ($sub) use ($search) {
                            $sub->where('name', 'like', "%{$search}%");
                        })
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('amount', 'like', "%{$search}%");
                });
            })
            ->when($categoryId, function ($query, $categoryId) {
                // Filter berdasarkan kategori
                $query->where('finance_category_id', $categoryId);
            })
            ->orderBy('date', 'desc')
            ->paginate(10)
            ->appends(['search' => $search, 'category' => $categoryId]); // bawa parameter saat pindah halaman

        return view('layouts.app', [
            'content' => view('pages.finance.finance-transactions.finance-transaction', compact(
                'data',
                'categories',
                'search',
                'categoryId'
            ))->render()
        ]);
    }



    public function create()
    {
        $financeTypes = FinanceType::whereRaw('LOWER(name) IN (?, ?)', ['income', 'expense'])->get();
        $financeAccounts = FinanceAccount::all();
        $financeCategories = FinanceCategory::inRandomOrder()->get();

        return view('layouts.app', [
            'content' => view('pages.finance.finance-transactions.finance-transaction-create', compact('financeAccounts', 'financeCategories', 'financeTypes'))->render()
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'finance_account_id'  => 'required|integer|exists:finance_accounts,id',
                'finance_category_id' => 'required|integer|exists:finance_categories,id',
                'finance_type_id'     => 'required|integer|exists:finance_types,id',
                'amount'              => 'required|numeric|min:0',
                'date'                => 'required|date',
                'description'         => 'nullable|string',
            ]);

            $account = FinanceAccount::findOrFail($validated['finance_account_id']);
            $type = FinanceType::findOrFail($validated['finance_type_id']);
            $userId = Auth::id();
            $date = \Carbon\Carbon::parse($validated['date']);

            // Tentukan tipe transaksi
            $isExpense = strtolower($type->name) === 'expense';
            $isIncome  = strtolower($type->name) === 'income';

            // 🔄 Update saldo akun
            if ($isExpense) {
                if ($account->balance < $validated['amount']) {
                    return back()->withInput()->with('error', 'Saldo tidak mencukupi untuk transaksi ini.');
                }
                $account->balance -= $validated['amount'];
            } elseif ($isIncome) {
                $account->balance += $validated['amount'];
            } else {
                return back()->withInput()->with('error', 'Transaction failed: Unknown transaction type.');
            }
            $account->save();

            // 🧾 Simpan transaksi
            FinanceTransaction::create([
                ...$validated,
                'created_by' => $userId,
            ]);

            // ======================
            // 🔢 Update Summary Table
            // ======================

            $incomeField = $isIncome ? 'income_total' : null;
            $expenseField = $isExpense ? 'expense_total' : null;
            $amount = $validated['amount'];

            // --- DAILY ---
            $daily = FinanceDailyBalance::firstOrNew([
                'date' => $date->toDateString(),
                'created_by' => $userId,
            ]);
            $daily->income_total  = ($daily->income_total ?? 0) + ($incomeField ? $amount : 0);
            $daily->expense_total = ($daily->expense_total ?? 0) + ($expenseField ? $amount : 0);
            $daily->save();

            // --- WEEKLY ---
            $week = $date->weekOfYear;
            $year = $date->year;
            $weekly = FinanceWeeklyBalance::firstOrNew([
                'year' => $year,
                'week' => $week,
                'created_by' => $userId,
            ]);
            $weekly->income_total  = ($weekly->income_total ?? 0) + ($incomeField ? $amount : 0);
            $weekly->expense_total = ($weekly->expense_total ?? 0) + ($expenseField ? $amount : 0);
            $weekly->save();

            // --- MONTHLY ---
            $month = $date->month;
            $monthly = FinanceMonthlyBalance::firstOrNew([
                'year' => $year,
                'month' => $month,
                'created_by' => $userId,
            ]);
            $monthly->income_total  = ($monthly->income_total ?? 0) + ($incomeField ? $amount : 0);
            $monthly->expense_total = ($monthly->expense_total ?? 0) + ($expenseField ? $amount : 0);
            $monthly->save();

            // --- YEARLY ---
            $yearly = FinanceYearlyBalance::firstOrNew([
                'year' => $year,
                'created_by' => $userId,
            ]);
            $yearly->income_total  = ($yearly->income_total ?? 0) + ($incomeField ? $amount : 0);
            $yearly->expense_total = ($yearly->expense_total ?? 0) + ($expenseField ? $amount : 0);
            $yearly->save();

            return redirect()->route('finance.transaction.index')
                ->with('success', 'Finance transaction successfully saved and summary updated.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Validation failed. Please check your input.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }


    // Transsaction
    public function transaction()
    {
        $financeTypes = FinanceType::whereRaw('LOWER(name) IN (?, ?)', ['income', 'expense'])->get();
        $financeAccounts = FinanceAccount::all();
        $financeCategories = FinanceCategory::inRandomOrder()->get();
        return view('transactions', compact('financeAccounts', 'financeCategories', 'financeTypes'));
    }


    public function transactionStore(Request $request)
    {
        try {
            $validated = $request->validate([
                'finance_account_id'  => 'required|integer|exists:finance_accounts,id',
                'finance_category_id' => 'required|integer|exists:finance_categories,id',
                'finance_type_id'     => 'required|integer|exists:finance_types,id',
                'amount'              => 'required|numeric|min:0',
                'date'                => 'required|date',
                'description'         => 'nullable|string',
            ]);

            $account = FinanceAccount::findOrFail($validated['finance_account_id']);
            $type = FinanceType::findOrFail($validated['finance_type_id']);
            $userId = Auth::id();
            $date = \Carbon\Carbon::parse($validated['date']);

            // Tentukan tipe transaksi
            $isExpense = strtolower($type->name) === 'expense';
            $isIncome  = strtolower($type->name) === 'income';

            // 🔄 Update saldo akun
            if ($isExpense) {
                if ($account->balance < $validated['amount']) {
                    return back()->withInput()->with('error', 'Saldo tidak mencukupi untuk transaksi ini.');
                }
                $account->balance -= $validated['amount'];
            } elseif ($isIncome) {
                $account->balance += $validated['amount'];
            } else {
                return back()->withInput()->with('error', 'Transaction failed: Unknown transaction type.');
            }
            $account->save();

            // 🧾 Simpan transaksi
            FinanceTransaction::create([
                ...$validated,
                'created_by' => $userId,
            ]);

            // ======================
            // 🔢 Update Summary Table
            // ======================

            $incomeField = $isIncome ? 'income_total' : null;
            $expenseField = $isExpense ? 'expense_total' : null;
            $amount = $validated['amount'];

            // --- DAILY ---
            $daily = FinanceDailyBalance::firstOrNew([
                'date' => $date->toDateString(),
                'created_by' => $userId,
            ]);
            $daily->income_total  = ($daily->income_total ?? 0) + ($incomeField ? $amount : 0);
            $daily->expense_total = ($daily->expense_total ?? 0) + ($expenseField ? $amount : 0);
            $daily->save();

            // --- WEEKLY ---
            $week = $date->weekOfYear;
            $year = $date->year;
            $weekly = FinanceWeeklyBalance::firstOrNew([
                'year' => $year,
                'week' => $week,
                'created_by' => $userId,
            ]);
            $weekly->income_total  = ($weekly->income_total ?? 0) + ($incomeField ? $amount : 0);
            $weekly->expense_total = ($weekly->expense_total ?? 0) + ($expenseField ? $amount : 0);
            $weekly->save();

            // --- MONTHLY ---
            $month = $date->month;
            $monthly = FinanceMonthlyBalance::firstOrNew([
                'year' => $year,
                'month' => $month,
                'created_by' => $userId,
            ]);
            $monthly->income_total  = ($monthly->income_total ?? 0) + ($incomeField ? $amount : 0);
            $monthly->expense_total = ($monthly->expense_total ?? 0) + ($expenseField ? $amount : 0);
            $monthly->save();

            // --- YEARLY ---
            $yearly = FinanceYearlyBalance::firstOrNew([
                'year' => $year,
                'created_by' => $userId,
            ]);
            $yearly->income_total  = ($yearly->income_total ?? 0) + ($incomeField ? $amount : 0);
            $yearly->expense_total = ($yearly->expense_total ?? 0) + ($expenseField ? $amount : 0);
            $yearly->save();

            return redirect()->route('transactions')
                ->with('success', 'Finance transaction successfully saved and summary updated.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Validation failed. Please check your input.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }
}
