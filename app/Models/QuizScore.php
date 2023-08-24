<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizScore extends Model {
    use HasFactory;

    protected $guarded = ['id'];

    function rel_to_enroll() {
        return $this->belongsTo(Enroll::class, 'enrollment_id');
    }
  
    function rel_to_quiz() {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }
}
