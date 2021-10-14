<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Support\Collection;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $commentCount = 100;

        $users = User::all();
        $articles = Article::all();

        $createdKey = new Collection();

        // user, articleをランダムでセットしたいので->countを使わずfor文で回している
        for ($i = 0; $i < $commentCount; $i++) {
            $userId = $users->random()->id;
            $articleId = $articles->random()->id;
            $createKey = ['userId' => $userId, 'articleId' => $articleId];

            // 既にユーザー、記事の組み合わせで登録されていたらスキップする
            if ($createdKey->contains($createKey)) {
                continue;
            }

            // 登録済みキーにセットして次回以降の重複排除に利用する
            $createdKey->push($createKey);

            Comment::factory()
                ->user($userId)
                ->article($articleId)
                ->create();
        }
    }
}
