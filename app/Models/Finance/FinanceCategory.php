<?php

namespace App\Models\Finance;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class FinanceCategory extends Model
{
    protected $table = 'finance_categories';

    protected $fillable = [
        'name',
        'type',
        'color',
        'created_by',
    ];

    // relationship to User (creator)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}