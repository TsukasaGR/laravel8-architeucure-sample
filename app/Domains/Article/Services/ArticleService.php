<?php

namespace App\Domains\Article\Services;

use App\Models\Article;
use InvalidArgumentException;

class ArticleService
{
    /**
     * @param Article $article
     */
    public function __construct(private Article $article)
    {
    }

    /**
     * 記事に紐づくコメントをページねージョンオブジェクトで返す
     *
     * @param int|null $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @throws InvalidArgumentException
     */
    public function articleCommentsPaginate(?int $perPage = null)
    {
        $perPage = $perPage ?? config('view.paginate.default');
        return $this->article->comments()
            ->defaultOrdered()
            ->paginate($perPage);
    }

    /**
     * @param int|null $userId
     * @return string|null
     * @comment 対象記事に対する対象ユーザのコメント取得
     */
    public function userComment(?int $userId = null): ?string
    {
        if (! $userId) {
            return null;
        }

        $comment = $this->article->comments()->whereUserId($userId)->first();
        if (! $comment) {
            return null;
        }

        return $comment->body;
    }

    // このような方法での実装もあるが、Serviceの責務は渡された$articleモデルを操作することであり、各種プロパティと入力フォームが密結合しているため、モデル生成まではController側で行うべきだと考えている
//    /**
//     * @param int $id
//     * @param int|null $categoryId
//     * @param string $url
//     * @param string $title
//     * @param string|null $description
//     * @param string|null $imagePath
//     * @return Article
//     * @comment 新規記事登録
//     */
//    public static function create(
//        int $userId,
//        ?int $categoryId,
//        string $url,
//        string $title,
//        ?string $description,
//        ?string $imagePath,
//    )
//    {
//        return Article::create([
//            'user_id' => $userId,
//            'category_id' => $categoryId,
//            'url' => $url,
//            'title' => $title,
//            'description' => $description,
//            'image_path' => $imagePath,
//        ]);
//    }

    /**
     * new Article()でDB未登録状態のモデルをDBに登録する
     * @return Article
     */
    public function create()
    {
        $this->article->save();
        return $this->article;
    }
}
