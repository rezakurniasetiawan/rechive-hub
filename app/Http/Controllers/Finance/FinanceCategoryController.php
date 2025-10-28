<?php

namespace App\Http\Controllers\Finance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Finance\FinanceCategory;
use App\Models\Finance\FinanceType;

class FinanceCategoryController extends Controller
{
    public function index()
    {
        $data = FinanceCategory::with([
            'financeType:id,name,label'
        ])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('layouts.app', [
            'content' => view('pages.finance.finance-categories.finance-category', compact('data'))->render()
        ]);
    }

    public function create()
    {
        $financeTypes = FinanceType::all();
        return view('layouts.app', [
            'content' => view('pages.finance.finance-categories.finance-category-create', compact('financeTypes'))->render()
        ]);
    }

    public function store(Request $request)
    {
        $validated  = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
        ]);
        FinanceCategory::create([
            ...$validated,
            'name'        => $request->name,
            'type'        => $request->type,
            'color'       => $request->color,
            'finance_type_id' => $request->finance_type_id,
            'created_by'  => Auth::id(),
        ]);

        return redirect()->route('finance.category.index')->with('success', 'Finance category created successfully.');
    }

    public function update($id)
    {
        $data = FinanceCategory::findOrFail($id);
        return view('layouts.app', [
            'content' => view('pages.finance.finance-categories.finance-category-update', compact('data'))->render()
        ]);
    }

    public function edit(Request $request, $id)
    {
        $validated  = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
        ]);

        $category = FinanceCategory::findOrFail($id);
        $category->update([
            ...$validated,
            'name'  => $request->name,
            'type'  => $request->type,
            'color' => $request->color,
            'finance_type_id' => $request->finance_type_id,
        ]);

        return redirect()->route('finance.category.index')->with('success', 'Finance category updated successfully.');
    }

    public function destroy($id)
    {
        $category = FinanceCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('finance.category.index')->with('success', 'Finance category deleted successfully.');
    }
}
