<?php

namespace App\Models\Calendars;

use Illuminate\Database\Eloquent\Model;

class ReserveSettings extends Model
{
    const UPDATED_AT = null;
    public $timestamps = false;

    protected $fillable = [
        'setting_reserve',
        'setting_part',
        'limit_users',
    ];

    public function users()
    {
        return $this->belongsToMany('App\Models\Users\User', 'reserve_setting_users', 'reserve_setting_id', 'user_id')->withPivot('reserve_setting_id', 'id');
    }

    public function getRemainingSlots($ymd, $part)
    {
        $reserveSetting = $this->where('setting_reserve', $ymd)
            ->where('setting_part', $part)
            ->withCount('users')
            ->first();
        $maxSlots = $reserveSetting ? $reserveSetting->limit_users : 20; // デフォルト値は20
        $reservedSlots = $reserveSetting ? $reserveSetting->users_count : 0;

        return $maxSlots - $reservedSlots;
    }
}