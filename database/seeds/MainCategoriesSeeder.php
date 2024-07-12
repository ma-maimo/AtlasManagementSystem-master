<?php

use App\Models\Categories\MainCategory;
use Illuminate\Database\Seeder;

class MainCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MainCategory::create([
            "main_category" => "教科",
        ]);
        MainCategory::create([
            "main_category" => "労働",
        ]);
        MainCategory::create([
            "main_category" => "遊び",
        ]);
    }
}