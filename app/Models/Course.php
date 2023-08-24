<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model {
    use HasFactory;
    protected $guarded = ['id'];

    function rel_to_course_cat() {
        return $this->belongsTo(CourseCategory::class, 'category_id');
    }

    function rel_to_course_type() {
        return $this->belongsTo(CourseType::class, 'type_id');
    }

}
