<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{

    protected $table = "contents";

    protected $fillable = [
        'content'
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'content_tags','content_id',
            'tag_id')->withTimestamps();
    }
}
