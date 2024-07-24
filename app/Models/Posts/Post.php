<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;
use App\Models\Categories\SubCategory;
use App\Models\Categories\MainCategory;
use App\Models\Posts\PostSubCategory;

class Post extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
        'user_id',
        'post_title',
        'post',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\Users\User');
    }

    public function postComments()
    {
        return $this->hasMany('App\Models\Posts\PostComment');
    }

    public function subCategories()
    {
        // リレーションの定義
        return $this->belongsToMany('App\Models\Categories\SubCategory', 'post_sub_categories', 'post_id', 'sub_category_id');
    }

    // 追加
    public function postSubCategory()
    {
        return $this->belongsTo('App\Models\Posts\PostSubCategory', 'post_id', 'id');
    }



    // コメント数をuser.phpに移動
    // public function commentCounts($post_id)
    // {
    //     return Post::with('postComments')->find($post_id)->postComments();
    // }

    // 追加
    public function likes()
    {
        return $this->hasMany(Like::class, 'like_post_id');
    }
}