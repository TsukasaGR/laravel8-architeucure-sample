<?php

namespace App\UseCases\Article\GetViewList;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface OutputPortInterface
{
    /**
     * @param LengthAwarePaginator $articlesPaginator
     */
    public function __construct(LengthAwarePaginator $articlesPaginator);

    /**
     * @return LengthAwarePaginator
     */
    public function getArticlePaginator(): LengthAwarePaginator;
}
