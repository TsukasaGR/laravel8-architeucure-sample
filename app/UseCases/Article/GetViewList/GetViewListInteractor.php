<?php

namespace App\UseCases\Article\GetViewList;

use App\Gateways\ArticleGatewayInterface;

class GetViewListInteractor
{
    /**
     * @param ArticleGatewayInterface $articleGateway
     */
    public function __construct(private ArticleGatewayInterface $articleGateway)
    {}

    /**
     * @param GetViewListInputPortInterface $inputPort
     * @return GetViewListOutputPortInterface
     */
    public function __invoke(GetViewListInputPortInterface $inputPort): GetViewListOutputPortInterface
    {
        $q = $inputPort->getQuery();
        $viewList = $this->articleGateway->viewListByPaginate($q);
        return new GetViewListOutputData($viewList);
    }
}
