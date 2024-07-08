<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class SubjectsUser extends Model
{
    const UPDATED_AT = null;

    protected $table = 'subject_users';
    protected $fillable = [
        'user_id',
        'subject_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\Users\User');
    }

    public function subjects()
    {
        return $this->belongsTo('App\Models\Users\Subjects');
    }
}