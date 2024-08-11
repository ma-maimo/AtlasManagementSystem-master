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
            "mail_address" => "tiikawa@tiikawa.com",
            "sex" => "2",
            "birth_day" => "2000-03-02",
            "role" => "4",
            "password" => bcrypt('tiikawa1234') //bcrypt( )→暗号化
        ]);
        User::create([
            "over_name" => "はち",
            "under_name" => "われ",
            "over_name_kana" => "ハチ",
            "under_name_kana" => "ワレ",
            "mail_address" => "hatiware@tiikawa.com",
            "sex" => "1",
            "birth_day" => "2000-05-01",
            "role" => "4",
            "password" => bcrypt('hatiware1234') //bcrypt( )→暗号化
        ]);
        User::create([
            "over_name" => "うさ",
            "under_name" => "ぎ",
            "over_name_kana" => "ウサ",
            "under_name_kana" => "ギ",
            "mail_address" => "usagi@tiikawa.com",
            "sex" => "3",
            "birth_day" => "2000-08-15",
            "role" => "4",
            "password" => bcrypt('usagi1234') //bcrypt( )→暗号化
        ]);
        User::create([
            "over_name" => "モモ",
            "under_name" => "ンガ",
            "over_name_kana" => "モモ",
            "under_name_kana" => "ンガ",
            "mail_address" => "momonga@tiikawa.com",
            "sex" => "3",
            "birth_day" => "2000-07-20",
            "role" => "4",
            "password" => bcrypt('momonga1234') //bcrypt( )→暗号化
        ]);
        User::create([
            "over_name" => "ポシェットの",
            "under_name" => "鎧",
            "over_name_kana" => "ポシェットノ",
            "under_name_kana" => "ヨロイ",
            "mail_address" => "poshetto@tiikawa.com",
            "sex" => "1",
            "birth_day" => "2000-11-23",
            "role" => "1",
            "password" => bcrypt('poshetto1234') //bcrypt( )→暗号化
        ]);
        User::create([
            "over_name" => "労働の",
            "under_name" => "鎧",
            "over_name_kana" => "ロウドウノ",
            "under_name_kana" => "ヨロイ",
            "mail_address" => "roudou@tiikawa.com",
            "sex" => "1",
            "birth_day" => "2000-06-13",
            "role" => "3",
            "password" => bcrypt('roudou1234') //bcrypt( )→暗号化
        ]);
        User::create([
            "over_name" => "ラッコ",
            "under_name" => "師匠",
            "over_name_kana" => "ラッコ",
            "under_name_kana" => "シショウ",
            "mail_address" => "rakko@tiikawa.com",
            "sex" => "1",
            "birth_day" => "2003-6-22",
            "role" => "3",
            "password" => bcrypt('rakko1234') //bcrypt( )→暗号化
        ]);
        User::create([
            "over_name" => "パジャマ",
            "under_name" => "ティーズ",
            "over_name_kana" => "パジャマ",
            "under_name_kana" => "ティーズ",
            "mail_address" => "pajama@tiikawa.com",
            "sex" => "3",
            "birth_day" => "2003-5-23",
            "role" => "4",
            "password" => bcrypt('pajama1234') //bcrypt( )→暗号化
        ]);
    }
}