<?php

namespace App\Presenters\Article;

use App\UseCases\Article\GetViewList\GetViewListOutputPortInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListViewModel
{
    public LengthAwarePaginator $articles;

    /**
     * @param GetViewListOutputPortInterface $getViewListOutputData
     * @param string|null $q
     */
    public function __construct(private GetViewListOutputPortInterface $getViewListOutputData, public ?string $q)
    {
        $this->articles = $this->getViewListOutputData->getArticlePaginator();
    }

    /**
     * @return ListViewModel[]
     */
    public function __invoke()
    {
        return ['listViewModel' => $this];
    }
}
