<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountIncome extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    function rel_to_branch() {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    function rel_to_enroll() {
        return $this->belongsTo(Enroll::class, 'enroll_id');
    }
}
