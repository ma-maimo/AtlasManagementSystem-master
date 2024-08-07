<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;
use App\Models\Posts\Post;
use App\Models\Posts\PostSubCategory;

class SubCategory extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $fillable = [
        'main_category_id',
        'sub_category',
    ];
    public function mainCategory()
    {
        // リレーションの定義
        return $this->belongsTo(MainCategory::class, 'main_category_id');
    }

    public function posts()
    {
        // リレーションの定義
        return $this->belongsToMany(Post::class, 'post_sub_categories', 'sub_category_id', 'post_id');
    }

    // 追加
    public function postSubCategories()
    {
        return $this->hasMany('App\Models\Posts\PostSubCategory', 'sub_category_id', 'id');
    }
}