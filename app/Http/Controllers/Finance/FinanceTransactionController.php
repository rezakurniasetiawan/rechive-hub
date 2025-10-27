<?php

namespace App\Http\Controllers\Finance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Finance\FinanceAccount;
use App\Models\Finance\FinanceCategory;
use App\Models\Finance\FinanceTransaction;

class FinanceTransactionController extends Controller
{
    public function index()
    {
        $data = FinanceTransaction::with([
            'financeAccount:id,bank_name,logo',
            'financeCategory:id,name,type'
        ])
            ->orderBy('date', 'desc')
            ->get();
        return view('layouts.app', [
            'content' => view('pages.finance.finance-transactions.finance-transaction', compact('data'))->render()
        ]);
    }


    public function create()
    {
        $financeAccounts = FinanceAccount::all();
        $financeCategories = FinanceCategory::all();

        return view('layouts.app', [
            'content' => view('pages.finance.finance-transactions.finance-transaction-create', compact('financeAccounts', 'financeCategories'))->render()
        ]);
    }

    public function store(Request $request)
    {
        try {
            // 🔍 Validasi input
            $validated = $request->validate([
                'finance_account_id'  => 'required|integer|exists:finance_accounts,id',
                'finance_category_id' => 'required|integer|exists:finance_categories,id',
                'amount'              => 'required|numeric|min:0',
                'date'                => 'required|date',
                'description'         => 'nullable|string',
            ]);

            $account = FinanceAccount::findOrFail($validated['finance_account_id']);

            // 🚨 Cek saldo cukup
            if ($account->balance < $validated['amount']) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Transaction failed: Insufficient balance in the selected account.');
            }

            // 💰 Kurangi saldo
            $account->balance -= $validated['amount'];
            $account->save();

            // 🧾 Simpan transaksi
            FinanceTransaction::create([
                ...$validated,
                'created_by' => Auth::id(),
            ]);

            return redirect()->route('finance.transaction.index')->with('success', 'Finance transaction created and balance successfully updated.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // ⚠️ Tangani error validasi (agar tampil di form)
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Validation failed. Please check your input.');
        } catch (\Exception $e) {
            // 🛑 Tangani error umum
            return redirect()->back()
                ->withInput()
                ->with('error', 'An unexpected error occurred: ' . $e->getMessage());
        }
    }
}
