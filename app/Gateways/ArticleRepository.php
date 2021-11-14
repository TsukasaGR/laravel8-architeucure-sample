<?php

namespace App\Gateways;

use App\Models\Article;
use App\Models\Domains\Article\ArticleRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ArticleRepository implements ArticleRepositoryInterface
{
    /**
     * @param string|null $q
     * @return LengthAwarePaginator
     */
    public function viewListByPaginate(?string $q): LengthAwarePaginator
    {
        return Article::viewList($q)
            ->paginate(20);
    }
}
