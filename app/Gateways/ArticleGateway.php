<?php

namespace App\Gateways;

use App\Models\Article;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ArticleGateway implements ArticleGatewayInterface
{
    /**
     * @param string|null $q
     * @return LengthAwarePaginator
     */
    public function viewListByPaginate(?string $q): LengthAwarePaginator
    {
        // Gatewayをモックした場合に当メソッドが呼び出されていないかを確認する際はコメントを外す
        // throw new \Exception();

        return Article::viewList($q)
            ->paginate(20);
    }
}
