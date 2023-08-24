<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'otp_verified_at' => 'datetime',
    ];

    public function branch() {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function enroll() {
        return $this->belongsTo(Enroll::class, 'id', 'user_id');
    }

    public function enrolls() {
        return $this->hasMany(Enroll::class);
    }
  
    public function online_course_enrolls() {
        return $this->hasMany(VidCourseEnroll::class);
    }

    public function idcard() {
        return $this->belongsTo(IDCard::class, 'id', 'user_id');
    }

    public function s_idcard() {
        return $this->belongsTo(StudentIdCard::class, 'id', 'user_id');
    }

    public function otp() {
        return $this->belongsTo(UserOtp::class, 'id', 'user_id');
    }
}
