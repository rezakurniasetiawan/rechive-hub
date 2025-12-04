<?php

namespace App\Http\Controllers\Finance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Finance\FinanceAccount;
use Illuminate\Support\Facades\Auth;

class FinanceAccountController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $userId = Auth::id();

        $data = FinanceAccount::when($userId, fn($q) => $q->where('created_by', $userId))
            ->when($search, function ($query, $search) {
                return $query->where('bank_name', 'like', '%' . $search . '%');
            })
            ->get();

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
        $userId = Auth::id();

        // ensure owner if logged in; otherwise behave like before
        $data = FinanceAccount::when($userId, fn($q) => $q->where('created_by', $userId))
            ->where('id', $id)
            ->firstOrFail();

        return view('layouts.app', [
            'content' => view('pages.finance.finance-accounts.finance-account-update', compact('data'))->render()
        ]);
    }

    // update (edit in your naming)
    public function edit(Request $request, $id)
    {
        $validated = $request->validate([
            'bank_name'   => 'required|string|max:255',
            'type'        => 'required|string|max:50',
            'fullname'    => 'required|string|max:255',
        ]);

        $userId = Auth::id();

        // ensure owner if logged in; otherwise allow as before
        $account = FinanceAccount::when($userId, fn($q) => $q->where('created_by', $userId))
            ->findOrFail($id);

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
        $userId = Auth::id();

        // ensure owner if logged in; otherwise behave like before
        $account = FinanceAccount::when($userId, fn($q) => $q->where('created_by', $userId))
            ->findOrFail($id);

        $account->delete();

        return redirect()->route('finance.account.index')->with('success', 'Finance account deleted successfully.');
    }
}
