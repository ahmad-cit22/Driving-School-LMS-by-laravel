<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogTagRelation extends Model {
    use HasFactory;

    protected $guarded = ['id'];

    public function tag() {
        return $this->belongsTo(BlogTag::class, 'tag_id', 'id');
    }
}
