<?php

use App\ReserveSettingUsers;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->insert([
        //     "over_name" => "ちい",
        //     "under_name" => "かわ",
        //     "over_name_kana" => "チイ",
        //     "under_name_kana" => "カワ",
        //     "mail_address" => "chiikawa@chiikawa.com",
        //     "sex" => "2",
        //     "birth_day" => "1995-05-01",
        //     "role" => "4",
        //     "password" => bcrypt('chiikawa1234') //bcrypt( )→暗号化
        // ]);

        $this->call([
            UsersTableSeeder::class,
            SubjectsTableSeeder::class,
            MainCategoriesSeeder::class,
            SubCategoriesSeeder::class,
            ReserveSettingUsersSeeder::class,
        ]);
    }
}