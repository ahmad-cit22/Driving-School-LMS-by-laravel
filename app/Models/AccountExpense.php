<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountExpense extends Model {
    use HasFactory;
    protected $guarded = ['id'];

    function rel_to_branch() {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
