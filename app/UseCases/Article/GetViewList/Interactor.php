<?php

namespace App\UseCases\Article\GetViewList;

use App\Gateways\ArticleGatewayInterface;

class Interactor
{
    /**
     * @param ArticleGatewayInterface $articleGateway
     */
    public function __construct(private ArticleGatewayInterface $articleGateway)
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
