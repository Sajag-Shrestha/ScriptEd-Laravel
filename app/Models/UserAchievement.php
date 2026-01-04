<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserAchievement extends Pivot
{
    use HasFactory;

    protected $table = 'user_achievements';
    protected $casts = [
        'earned_at'    => 'datetime',
        'progress_data' => 'array',
    ];
    public $timestamps = true;

    public function achievement()
    {
        return $this->belongsTo(Achievement::class);
    }
}
