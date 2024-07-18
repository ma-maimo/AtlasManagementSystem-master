<?php

namespace App\Models\Users;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Users\Subjects;

use App\Models\Posts\Like;
use App\Models\Posts\PostComment;
use App\Models\Calendars\ReserveSettings;
use Auth;

class User extends Authenticatable
{
    use Notifiable;
    use softDeletes;

    const CREATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'over_name',
        'under_name',
        'over_name_kana',
        'under_name_kana',
        'mail_address',
        'sex',
        'birth_day',
        'role',
        'password'
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany('App\Models\Posts\Post');
    }

    public function calendars()
    {
        return $this->belongsToMany('App\Models\Calendars\Calendar', 'calendar_users', 'user_id', 'calendar_id')->withPivot('user_id', 'id');
    }

    public function reserveSettings()
    {
        return $this->belongsToMany('App\Models\Calendars\ReserveSettings', 'reserve_setting_users', 'user_id', 'reserve_setting_id')->withPivot('id');
    }

    public function subjects()
    {
        // リレーションの定義
        return $this->belongsToMany('App\Models\Users\Subjects', 'subject_users', 'user_id', 'subject_id');
    }

    // いいね
    public function is_Like($post_id)
    {
        return Like::where('like_user_id', Auth::id())->where('like_post_id', $post_id)->first(['likes.id']);
    }

    public function likePostId()
    {
        return Like::where('like_user_id', Auth::id());
    }


    // コメント
    public function is_Comment($post_id)
    {
        return PostComment::where('post_id', $post_id)->count();
    }

    // public function comments()
    // {
    //     return $this->hasMany(PostComment::class, 'user_id');
    // }



    // ついか
    // public function authReserveDay()
    // {
    //     return $this->reserves()->pluck('setting_reserve')->toArray();
    // }

    // public function authReserveDate($date)
    // {
    //     return $this->reserves()->where('setting_reserve', $date)->get();
    // }

    // public function reserves()
    // {
    //     return $this->belongsToMany(ReserveSettings::class, 'reserve_setting_users', 'user_id', 'reserve_setting_id');
    // }
}