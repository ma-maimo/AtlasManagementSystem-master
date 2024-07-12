<?php

use Illuminate\Database\Seeder;
use App\Models\Categories\SubCategory;

class SubCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 教科
        SubCategory::create([
            "main_category_id" => "1",
            "sub_category" => "国語",
        ]);
        SubCategory::create([
            "main_category_id" => "1",
            "sub_category" => "数学",
        ]);
        SubCategory::create([
            "main_category_id" => "1",
            "sub_category" => "英語",
        ]);

        // 労働
        SubCategory::create([
            "main_category_id" => "2",
            "sub_category" => "草むしり",
        ]);
        SubCategory::create([
            "main_category_id" => "2",
            "sub_category" => "討伐",
        ]);

        // 遊び
        SubCategory::create([
            "main_category_id" => "3",
            "sub_category" => "ひなたぼっこ",
        ]);
    }
}