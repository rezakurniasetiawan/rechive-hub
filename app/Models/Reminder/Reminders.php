<?php

namespace App\Models\Reminder;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Reminders extends Model
{

    protected $table = 'reminders';
    protected $fillable = [
        'title',
        'description',
        'target_date',
        'is_primary',
        'category',
        'repeat_type',
        'notify_before_hours',
        'status',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
