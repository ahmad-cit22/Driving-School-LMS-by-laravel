<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounterFact extends Model {
    use HasFactory;
    protected $guarded = ['id'];
}
