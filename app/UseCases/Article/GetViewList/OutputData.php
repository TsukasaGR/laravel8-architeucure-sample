<?php

namespace App\UseCases\Article\GetViewList;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OutputData implements OutputPortInterface
{
    /**
     * @param LengthAwarePaginator $articlePaginator
     */
    public function __construct(private LengthAwarePaginator $articlePaginator)
    {
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getArticlePaginator(): LengthAwarePaginator
    {
        return $this->articlePaginator;
    }
}
