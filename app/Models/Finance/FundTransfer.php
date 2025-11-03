<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;

class FundTransfer extends Model
{
    protected $table = 'fund_transfers';
    protected $fillable = [
        'from_account_id',
        'to_account_id',
        'amount',
        'date',
    ];


    public function fromAccount()
    {
        return $this->belongsTo(FinanceAccount::class, 'from_account_id');
    }
    public function toAccount()
    {
        return $this->belongsTo(FinanceAccount::class, 'to_account_id');
    }
}
