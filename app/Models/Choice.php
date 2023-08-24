<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    function rel_to_question() {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
