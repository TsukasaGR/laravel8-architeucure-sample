<?php

namespace App\UseCases\Article\GetViewList;

use App\Models\Domains\Article\ArticleRepositoryInterface;

class Interactor
{
    /**
     * @param ArticleRepositoryInterface $articleGateway
     */
    public function __construct(private ArticleRepositoryInterface $articleGateway)
    {
    }

    /**
     * @param InputPortInterface $inputPort
     * @return OutputPortInterface
     */
    public function __invoke(InputPortInterface $inputPort): OutputPortInterface
    {
        $q = $inputPort->getQuery();
        $viewList = $this->articleGateway->viewListByPaginate($q);
        return new OutputData($viewList);
    }
}
