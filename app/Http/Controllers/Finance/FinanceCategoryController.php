<?php

namespace App\Http\Controllers\Finance;

use Illuminate\Http\Request;
use App\Models\Finance\FinanceType;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Finance\FinanceCategory;
use App\Models\Finance\FinanceSubCategory;

class FinanceCategoryController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $data = FinanceCategory::when($userId, fn($q) => $q->where('created_by', $userId))
            ->with([
                'financeType:id,name,label',
                'financeSubCategories'
            ])
            ->orderBy('created_at', 'desc')
            ->inRandomOrder()
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
        $userId = Auth::id();

        $data = FinanceCategory::when($userId, fn($q) => $q->where('created_by', $userId))
            ->findOrFail($id);

        $financeTypes = FinanceType::all();
        return view('layouts.app', [
            'content' => view('pages.finance.finance-categories.finance-category-update', compact('data', 'financeTypes'))->render()
        ]);
    }

    public function edit(Request $request, $id)
    {
        $validated  = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
        ]);

        $userId = Auth::id();

        $category = FinanceCategory::when($userId, fn($q) => $q->where('created_by', $userId))
            ->findOrFail($id);

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
        $userId = Auth::id();

        $category = FinanceCategory::when($userId, fn($q) => $q->where('created_by', $userId))
            ->findOrFail($id);
        $category->delete();

        return redirect()->route('finance.category.index')->with('success', 'Finance category deleted successfully.');
    }


    // Sub Category 
    public function subIndex($id)
    {
        $userId = Auth::id();

        // ensure category exists and belongs to user if logged in
        $category = FinanceCategory::when($userId, fn($q) => $q->where('created_by', $userId))
            ->findOrFail($id);

        $subs = FinanceSubCategory::when($userId, fn($q) => $q->where('created_by', $userId))
            ->where('finance_category_id', $id)
            ->get();

        return view('layouts.app', [
            'content' => view('pages.finance.finance-categories.finance-sub-categories.finance-sub-category', compact('category', 'subs'))->render()
        ]);
    }

    public function subCreate($id)
    {
        $userId = Auth::id();

        // ensure category exists and belongs to user if logged in
        $category = FinanceCategory::when($userId, fn($q) => $q->where('created_by', $userId))
            ->findOrFail($id);

        return view('layouts.app', [
            'content' => view('pages.finance.finance-categories.finance-sub-categories.finance-sub-category-create', compact('category'))->render()
        ]);
    }

    public function subStore(Request $request, $id)
    {
        $userId = Auth::id();

        // ensure category exists and belongs to user if logged in
        FinanceCategory::when($userId, fn($q) => $q->where('created_by', $userId))
            ->findOrFail($id);

        FinanceSubCategory::create([
            'name' => $request->name,
            'color' => $request->color,
            'finance_category_id' => $id,
            'created_by'  => $userId,
        ]);

        return redirect()->route('finance.category.index')->with('success', 'Finance sub category created successfully.');
    }

    public function subUpdate($categoryId, $subId)
    {
        $userId = Auth::id();

        // ensure category exists and belongs to user if logged in
        $category = FinanceCategory::when($userId, fn($q) => $q->where('created_by', $userId))
            ->findOrFail($categoryId);

        $sub = FinanceSubCategory::when($userId, fn($q) => $q->where('created_by', $userId))
            ->where('finance_category_id', $categoryId)
            ->findOrFail($subId);

        return view('layouts.app', [
            'content' => view('pages.finance.finance-categories.finance-sub-categories.finance-sub-category-update', compact('category', 'sub'))->render()
        ]);
    }

    public function subEdit(Request $request, $categoryId, $subId)
    {
        $userId = Auth::id();

        $sub = FinanceSubCategory::when($userId, fn($q) => $q->where('created_by', $userId))
            ->where('finance_category_id', $categoryId)
            ->findOrFail($subId);

        $sub->update([
            'name' => $request->name,
            'color' => $request->color,
        ]);

        return redirect()->route('finance.category.index')->with('success', 'Sub category updated');
    }

    public function subDestroy($categoryId, $subId)
    {
        $userId = Auth::id();

        $sub = FinanceSubCategory::when($userId, fn($q) => $q->where('created_by', $userId))
            ->where('finance_category_id', $categoryId)
            ->findOrFail($subId);

        $sub->delete();

        return redirect()->route('finance.category.index')->with('success', 'Finance sub category deleted successfully.');
    }
}
