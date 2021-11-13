<?php

namespace App\Gateways;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ArticleGatewayInterface
{
    /**
     * @param string|null $q
     * @return LengthAwarePaginator
     */
    public function viewListByPaginate(?string $q): LengthAwarePaginator;
}
