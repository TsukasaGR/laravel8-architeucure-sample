<?php

namespace App\UseCases\Article\GetViewList;

interface GetViewListInputPortInterface
{
    /**
     * @param string|null $q
     */
    public function __construct(?string $q);

    /**
     * @return string|null
     */
    public function getQuery(): ?string;
}
