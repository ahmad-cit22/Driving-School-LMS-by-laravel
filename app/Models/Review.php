<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model {
    use HasFactory;

    protected $guarded = ['id'];

    function rel_to_enroll() {
        return $this->belongsTo(Enroll::class, 'enrollment_id');
    }

}
