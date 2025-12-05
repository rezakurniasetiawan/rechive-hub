<?php

namespace App\Models\Budget;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{

    protected $table = 'budgets';
    protected $fillable = [
        'name',
        'month',
        'year',
        'total_budget',
        'total_used',
        'total_remaining',
        'status',
        'is_locked',
        'note',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

}