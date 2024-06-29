<?php

use Illuminate\Database\Seeder;
use App\Models\Users\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // sex[1:男性 / 2:女性 / 3:その他]
        // role[1:教師(国語) / 2:教師(数学) / 3:教師(英語) / 4:生徒]

        User::create([
            "over_name" => "ちい",
            "under_name" => "かわ",
            "over_name_kana" => "チイ",
            "under_name_kana" => "カワ",
            "mail_address" => "chiikawa@chiikawa.com",
            "sex" => "2",
            "birth_day" => "1995-05-01",
            "role" => "4",
            "password" => bcrypt('chiikawa1234') //bcrypt( )→暗号化
        ]);
    }
}