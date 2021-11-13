<?php

namespace App\UseCases\Article\GetViewList;

class GetViewListInputData implements GetViewListInputPortInterface
{
    /**
     * @param string|null $q
     */
    public function __construct(private ?string $q)
    {}

    /**
     * @return string|null
     */
    public function getQuery(): ?string
    {
        return $this->q;
    }
}
