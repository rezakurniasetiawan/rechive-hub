<?php

namespace App\Models\SPIManager;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class SPIManagerLink extends Model
{
    protected $table = 's_p_i_manager_links';
    protected $fillable = [
        'video_url',
        'platform',
        'status',
        'copied_at',
        'created_by',
    ];


    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
