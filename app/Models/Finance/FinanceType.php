<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;

class FinanceType extends Model
{
    protected $table = 'finance_types';

    protected $fillable = [
        'name',
        'label',
    ];
}
