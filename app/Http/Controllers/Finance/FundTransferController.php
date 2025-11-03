<?php

namespace App\Http\Controllers\Finance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Finance\FundTransfer;
use App\Models\Finance\FinanceAccount;

class FundTransferController extends Controller
{
    public function index()
    {
        $accounts = FinanceAccount::all();

        // Gunakan pagination (misal 10 data per halaman)
        $fundTransfers = FundTransfer::with(['fromAccount', 'toAccount'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Kirim data ke view utama
        return view('layouts.app', [
            'content' => view('pages.finance.fund-transfers.fund-transfer', compact('accounts', 'fundTransfers'))->render()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'from_account_id' => 'required|exists:finance_accounts,id',
            'to_account_id' => 'required|exists:finance_accounts,id',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
        ]);

        if ($request->amount > FinanceAccount::find($request->from_account_id)->balance) {
            return redirect()->back()->withErrors(['error' => 'Insufficient funds in the from account.'])->withInput();
        }

        if ($request->from_account_id == $request->to_account_id) {
            return redirect()->back()->withErrors(['error' => 'From and To accounts must be different.'])->withInput();
        }

        $fromAccount = FinanceAccount::find($request->from_account_id);
        $toAccount = FinanceAccount::find($request->to_account_id);

        $fromAccount->decrement('balance', $request->amount);
        $toAccount->increment('balance', $request->amount);

        FundTransfer::create([
            'from_account_id' => $request->from_account_id,
            'to_account_id' => $request->to_account_id,
            'amount' => $request->amount,
            'date' => $request->date,
        ]);

        return redirect()->back()->with('success', 'Fund transfer recorded successfully.');
    }
}
