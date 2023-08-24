<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VidCourseCertificate extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function vid_course_enroll() {
        return $this->belongsTo(VidCourseEnroll::class, 'enroll_id');
    }
}
