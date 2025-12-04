<?php

namespace App\Http\Controllers\Finance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Finance\FundTransfer;
use App\Models\Finance\FinanceAccount;
use Illuminate\Support\Facades\Auth;

class FundTransferController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Hanya tampilkan akun yang dimiliki user login
        $accounts = FinanceAccount::when($userId, fn($q) => $q->where('created_by', $userId))
            ->get();

        // Hanya tampilkan fund transfer milik user login
        $fundTransfers = FundTransfer::with(['fromAccount', 'toAccount'])
            ->when($userId, fn($q) => $q->where('created_by', $userId))
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('layouts.app', [
            'content' => view(
                'pages.finance.fund-transfers.fund-transfer',
                compact('accounts', 'fundTransfers')
            )->render()
        ]);
    }

    public function store(Request $request)
    {
        $userId = Auth::id();

        $request->validate([
            'from_account_id' => 'required|exists:finance_accounts,id',
            'to_account_id'   => 'required|exists:finance_accounts,id',
            'amount'          => 'required|numeric|min:0.01',
            'date'            => 'required|date',
        ]);

        // Hanya boleh transfer antar akun milik user login
        $fromAccount = FinanceAccount::where('id', $request->from_account_id)
            ->when($userId, fn($q) => $q->where('created_by', $userId))
            ->firstOrFail();

        $toAccount = FinanceAccount::where('id', $request->to_account_id)
            ->when($userId, fn($q) => $q->where('created_by', $userId))
            ->firstOrFail();

        // Validasi saldo cukup
        if ($request->amount > $fromAccount->balance) {
            return redirect()->back()
                ->withErrors(['error' => 'Insufficient funds in the from account.'])
                ->withInput();
        }

        // Tidak boleh transfer ke akun yang sama
        if ($request->from_account_id == $request->to_account_id) {
            return redirect()->back()
                ->withErrors(['error' => 'From and To accounts must be different.'])
                ->withInput();
        }

        // Update saldo
        $fromAccount->decrement('balance', $request->amount);
        $toAccount->increment('balance', $request->amount);

        // Simpan fund transfer + created_by
        FundTransfer::create([
            'from_account_id' => $request->from_account_id,
            'to_account_id'   => $request->to_account_id,
            'amount'          => $request->amount,
            'date'            => $request->date,
            'created_by'      => $userId, // 🟢 penting!
        ]);

        return redirect()->back()->with('success', 'Fund transfer recorded successfully.');
    }
}
