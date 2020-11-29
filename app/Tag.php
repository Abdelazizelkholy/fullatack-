<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';
    protected $fillable = [
        'id',
        'tagName'
    ];

    public function Blogs()
    {
        return $this->belongsToMany(Blog::class);
    }
}
