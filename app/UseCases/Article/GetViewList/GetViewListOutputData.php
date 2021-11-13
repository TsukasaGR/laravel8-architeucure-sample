<?php

namespace App\UseCases\Article\GetViewList;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetViewListOutputData implements GetViewListOutputPortInterface
{
    /**
     * @param LengthAwarePaginator $articlePaginator
     */
    public function __construct(private LengthAwarePaginator $articlePaginator)
    {}

    /**
     * @return LengthAwarePaginator
     */
    public function getArticlePaginator(): LengthAwarePaginator
    {
        return $this->articlePaginator;
    }
}
