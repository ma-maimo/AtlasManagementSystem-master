<?php

use Illuminate\Database\Seeder;
use App\Models\Calendars\ReserveSettingUsers;

class ReserveSettingUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ReserveSettingUsers::create([
            "user_id" => "2",
            "reserve_setting_id" => "1",
        ]);
        ReserveSettingUsers::create([
            "user_id" => "2",
            "reserve_setting_id" => "5",
        ]);
    }
}