<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinanceMonthlyBalance extends Model
{
    use HasFactory;

    protected $table = 'finance_monthly_balances';

    protected $fillable = [
        'year',
        'month',
        'income_total',
        'expense_total',
        'created_by',
    ];
}
