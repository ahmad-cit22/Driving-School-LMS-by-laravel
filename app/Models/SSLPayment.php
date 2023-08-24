<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SSLPayment extends Model
{
    use HasFactory;

    public function rel_to_enroll() {
        return $this->belongsTo(Enroll::class, 'enroll_id');
    }

}
