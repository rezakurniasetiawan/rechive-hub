<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinanceYearlyBalance extends Model
{
    use HasFactory;

    protected $table = 'finance_yearly_balances';

    protected $fillable = [
        'year',
        'income_total',
        'expense_total',
        'created_by',
    ];
}
