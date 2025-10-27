<?php

namespace App\Http\Controllers\Finance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Finance\FinanceCategory;

class FinanceCategoryController extends Controller
{
    public function index()
    {
        $data = FinanceCategory::all();
        return view('layouts.app', [
            'content' => view('pages.finance.finance-categories.finance-category', compact('data'))->render()
        ]);
    }

    public function create()
    {
        return view('layouts.app', [
            'content' => view('pages.finance.finance-categories.finance-category-create')->render()
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