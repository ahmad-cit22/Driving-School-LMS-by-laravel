<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoCourse extends Model {
    use HasFactory;

    protected $guarded = ['id'];

    function rel_to_course_cat() {
        return $this->belongsTo(CourseCategory::class, 'course_category');
    }

    function rel_to_course_type() {
        return $this->belongsTo(CourseType::class, 'course_type');
    }
}
