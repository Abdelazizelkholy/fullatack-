<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blogcategory extends Model
{
    protected $fillable = [
        'blog_id', 'category_id'
    ];
}
