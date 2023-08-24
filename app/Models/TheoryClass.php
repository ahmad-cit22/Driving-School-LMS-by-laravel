<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TheoryClass extends Model {
    use HasFactory;

    protected $guarded = ['id'];

    public function branch() {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function days() {
        return $this->belongsTo(Day::class, 'day', 'id');
    }
}
