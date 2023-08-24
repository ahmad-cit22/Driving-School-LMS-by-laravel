<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookedSchedule extends Model {
    use HasFactory;

    protected $guarded = ['id'];

    public function enroll() {
        return $this->belongsTo(Enroll::class, 'enroll_id', 'id');
    }
}
