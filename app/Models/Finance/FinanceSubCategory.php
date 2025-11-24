<?php

namespace App\Models\Finance;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class FinanceSubCategory extends Model
{
    protected $table = 'finance_sub_categories';

    protected $fillable = [
        'name',
        'color',
        'finance_category_id',
        'created_by',
    ];


    public function financeCategory()
    {
        return $this->belongsTo(FinanceCategory::class, 'finance_category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}