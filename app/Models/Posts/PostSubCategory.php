<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;
use App\Models\Categories\SubCategory;

class PostSubCategory extends Model
{
    const UPDATED_AT = null;

    protected $table = 'post_sub_categories';
    protected $fillable = [
        'post_id',
        'sub_category_id',
    ];

    public function posts()
    {
        return $this->belongsTo('App\Models\Posts\Post');
    }

    public function subCategory()
    {
        return $this->belongsTo('App\Models\Categories\SubCategory', 'sub_category_id', 'id');
    }
}