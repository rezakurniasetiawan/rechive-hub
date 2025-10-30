<?php

namespace App\Http\Controllers\Finance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Finance\FinanceAccount;
use Illuminate\Support\Facades\Auth;

class FinanceAccountController extends Controller
{
    public function index()
    {
        $data = FinanceAccount::all();
        return view('layouts.app', [
            'content' => view('pages.finance.finance-accounts.finance-account', compact('data'))->render()
        ]);
    }

    public function create()
    {
        return view('layouts.app', [
            'content' => view('pages.finance.finance-accounts.finance-account-create')->render()
        ]);
    }

    // create
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bank_name'   => 'required|string|max:255',
            'type'        => 'required|string|max:50',
            'fullname'    => 'required|string|max:255',
        ]);

        FinanceAccount::create([
            ...$validated,
            'bank_number' => $request->bank_number,
            'fullname'    => $request->fullname,
            'balance'     => $request->balance ?? 0,
            'logo'        => $request->logo ?? 'https://dpmptsp.merauke.go.id/assets/public/investasi/default.jpg',
            'created_by'  => Auth::id(),
        ]);

        return redirect()->route('finance.account.index')->with('success', 'Finance account created successfully.');
    }


    public function update($id)
    {
        $data = FinanceAccount::where('id', $id)->first();
        return view('layouts.app', [
            'content' => view('pages.finance.finance-accounts.finance-account-update', compact('data'))->render()
        ]);
    }

    // update
    public function edit(Request $request, $id)
    {
        $validated = $request->validate([
            'bank_name'   => 'required|string|max:255',
            'type'        => 'required|string|max:50',
            'fullname'    => 'required|string|max:255',
        ]);

        $account = FinanceAccount::findOrFail($id);
        $account->update([
            ...$validated,
            'bank_number' => $request->bank_number,
            'fullname'    => $request->fullname,
            'balance'     => $request->balance ?? $account->balance,
            'logo'        => $request->logo ?? $account->logo,
            'updated_by'  => Auth::id(),
        ]);

        return redirect()->route('finance.account.index')->with('success', 'Finance account updated successfully.');
    }

    public function destroy($id)
    {
        $account = FinanceAccount::findOrFail($id);
        $account->delete();

        return redirect()->route('finance.account.index')->with('success', 'Finance account deleted successfully.');
    }
}