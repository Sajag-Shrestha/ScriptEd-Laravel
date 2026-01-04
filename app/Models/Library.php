<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Library extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'module_id',
        'date_added',
        'last_opened',
        'progress',
        'time_spent',
        'status',
        'is_in_library'
    ];

    protected $casts = [
        'date_added' => 'datetime',
        'last_opened' => 'datetime',
        'time_spent' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
