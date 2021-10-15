<?php

namespace App\Services\Domains\Article;

use App\Models\Article;
use App\Models\Comment;

class DeleteArticleService
{
    /**
     * @param Article $article
     */
    public function __construct(private Article $article)
    {
    }

    /**
     * @return void
     */
    public function __invoke()
    {
        Comment::whereArticleId($this->article->id)->delete();
        $this->article->delete();
    }
}
