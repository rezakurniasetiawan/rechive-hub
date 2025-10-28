<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinanceWeeklyBalance extends Model
{
    use HasFactory;

    protected $table = 'finance_weekly_balances';

    protected $fillable = [
        'year',
        'week',
        'income_total',
        'expense_total',
        'created_by',
    ];
}
