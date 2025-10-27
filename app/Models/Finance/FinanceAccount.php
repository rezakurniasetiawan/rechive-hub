<?php

namespace App\Models\Finance;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class FinanceAccount extends Model
{
    protected $table = 'finance_accounts';

    protected $fillable = [
        'bank_name',
        'bank_number',
        'fullname',
        'type',
        'balance',
        'logo',
        'created_by',
    ];

    // relationship to User (creator)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
