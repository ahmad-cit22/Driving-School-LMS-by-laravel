<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enroll extends Model {
    use HasFactory;

    protected $guarded = ['id'];

    public function booked() {
        return $this->hasMany(BookedSchedule::class);
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function branch() {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function course() {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
  
    public function category() {
        return $this->belongsTo(CourseCategory::class, 'course_category', 'id');
    }

    public function type() {
        return $this->belongsTo(CourseType::class, 'course_type', 'id');
    }

    public function slot() {
        return $this->belongsTo(CourseSlot::class, 'course_slot', 'id');
    }

    protected $casts = [
        'start_date' => 'datetime',
    ];
}
