<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => '設計'],
            ['name' => 'インフラ'],
            ['name' => 'サーバーサイド'],
            ['name' => 'フロントエンド'],
            ['name' => 'マネジメント'],
            ['name' => '雑学'],
        ];
        foreach ($categories as $category) {
            Category::create(['name' => $category['name']]);
        }
    }
}
