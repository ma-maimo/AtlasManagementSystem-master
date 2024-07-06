<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class PostSubCategory extends Model
{
    const UPDATED_AT = null;

    protected $table = 'post_sub_categories';
    protected $fillable = [
        'post_id',
        'sub_category_id',
    ];

    public function post()
    {
        return $this->belongsTo('App\Models\Posts\Post');
    }

    public function SubCategory()
    {
        return $this->belongsTo('App\Models\Categories\SubCategory');
    }
}