<?php

namespace App\Presenters\Article;

use App\Models\Domains\Article\IndexViewModel;
use App\UseCases\Article\GetViewList\OutputPortInterface;

class IndexPresenter
{
    public IndexViewModel $viewModel;

    /**
     * @param OutputPortInterface $getViewListOutputData
     * @param string|null $q
     */
    public function __construct(private OutputPortInterface $getViewListOutputData, public ?string $q)
    {
        $this->viewModel = new IndexViewModel($this->getViewListOutputData->getArticlePaginator(), $q);
    }

    /**
     * @return IndexViewModel[]
     */
    public function __invoke()
    {
        return ['indexViewModel' => $this->viewModel];
    }
}
