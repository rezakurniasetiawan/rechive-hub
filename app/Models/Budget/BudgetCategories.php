<?php

namespace App\Models\Budget;

use Illuminate\Database\Eloquent\Model;

class BudgetCategories extends Model
{

    protected $table = 'budget_categories';
    protected $fillable = [
        'budget_id',
        'finance_category_id',
        'allocated_amount',
        'used_amount',
        'percentage',
        'alert_threshold',
    ];

    public function budget()
    {
        return $this->belongsTo(Budget::class, 'budget_id');
    }
}
