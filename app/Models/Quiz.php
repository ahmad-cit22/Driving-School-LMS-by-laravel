<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function category() {
        return $this->belongsTo(CourseCategory::class, 'course_id', 'id');
    }

    public function type() {
        return $this->belongsTo(CourseType::class, 'course_type', 'id');
    }
}
