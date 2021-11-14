<?php

namespace App\Models\Domains\Article;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ArticleRepositoryInterface
{
    /**
     * @param string|null $q
     * @return LengthAwarePaginator
     */
    public function viewListByPaginate(?string $q): LengthAwarePaginator;
}
