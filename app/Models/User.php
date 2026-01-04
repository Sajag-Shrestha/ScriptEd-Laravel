<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @method \Illuminate\Database\Eloquent\Relations\BelongsToMany affiliatedStudents()
 * @method \Illuminate\Database\Eloquent\Relations\BelongsToMany affiliatedTeachers()
 */
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'profile_image',
        'last_login',
        'xp',
        'rank_id',
        'google_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'last_login' => 'datetime'
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function libraries()
    {
        return $this->hasMany(Library::class);
    }

    public function role_requests()
    {
        return $this->hasMany(RoleRequest::class);
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'user_achievements')
            ->using(UserAchievement::class)
            ->withPivot('earned_at', 'progress_data')
            ->withTimestamps();
    }

    public function rank()
    {
        return $this->belongsTo(Rank::class);
    }

    public function affiliatedStudents()
    {
        return $this->belongsToMany(User::class, 'affiliations', 'teacher_id', 'student_id');
    }

    public function affiliatedTeachers()
    {
        return $this->belongsToMany(User::class, 'affiliations', 'student_id', 'teacher_id');
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'teacher_id');
    }

    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class, 'student_id');
    }

}
