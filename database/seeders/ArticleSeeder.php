<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Article;
use App\Models\Category;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $articleCount = 100;
        $users = User::all();
        $category = Category::all();

        // user, categoryをランダムでセットしたいので->countを使わずfor文で回している
        for ($i = 0; $i < $articleCount; $i++) {
            Article::factory()
                ->user($users->random()->id)
                ->category($category->random()->id)
                ->create();
        }
    }
}
