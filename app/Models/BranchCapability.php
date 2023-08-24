<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchCapability extends Model {
    use HasFactory;
    protected $guarded = ['id'];

    public function branch() {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function category() {
        return $this->belongsTo(CourseCategory::class, 'category_id', 'id');
    }

    public function slot() {
        return $this->hasMany(CourseSlot::class, 'branch_id');
    }
}
