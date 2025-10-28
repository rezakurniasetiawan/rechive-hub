<?php

namespace App\Models\Finance;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class FinanceCategory extends Model
{
    protected $table = 'finance_categories';

    protected $fillable = [
        'name',
        'color',
        'finance_type_id',
        'created_by',
    ];

    public function financeType()
    {
        return $this->belongsTo(FinanceType::class, 'finance_type_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
