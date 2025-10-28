<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinanceDailyBalance extends Model
{
    use HasFactory;

    protected $table = 'finance_daily_balances';

    protected $fillable = [
        'date',
        'income_total',
        'expense_total',
        'created_by',
    ];
}
