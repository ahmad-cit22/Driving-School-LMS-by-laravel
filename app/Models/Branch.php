<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model {
    use HasFactory;

    protected $guarded = ['id'];

    public function capability() {
        return $this->belongsTo(BranchCapability::class, 'id', 'branch_id');
    }

    public function slot() {
        return $this->belongsTo(CourseSlot::class, 'id', 'branch_id');
    }

    public function theory_class() {
        return $this->hasMany(TheoryClass::class, 'branch_id');
    }

    public function signature() {
        return $this->belongsTo(ManagerSignature::class, 'branch_id');
    }

    public function enrolls() {
        return $this->hasMany(Enroll::class);
    }
   
    public function incomes() {
        return $this->hasMany(AccountIncome::class);
    }
    
    public function expenses() {
        return $this->hasMany(AccountExpense::class);
    }
}
