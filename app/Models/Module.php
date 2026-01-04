<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function libraries()
    {
        return $this->hasMany(Library::class);
    }

}
