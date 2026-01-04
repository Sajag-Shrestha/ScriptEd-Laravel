<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'icon', 'type', 'xp_reward', 'criteria_module', 'criteria_amount'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_achievements')
            ->withTimestamps()
            ->withPivot('earned_at', 'progress_data');
    }

    public function module()
    {
        return $this->belongsTo(Module::class, 'criteria_module', 'id');
    }
}
