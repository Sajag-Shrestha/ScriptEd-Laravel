<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'title',
        'description',
        'source',
        'type',
        'url',
        'order',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
