<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VidCourseEnroll extends Model {
    use HasFactory;

    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vid_course() {
        return $this->belongsTo(VideoCourse::class, 'vid_course_id');
    }
}
