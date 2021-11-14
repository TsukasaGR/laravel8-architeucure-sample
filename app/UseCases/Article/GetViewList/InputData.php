<?php

namespace App\UseCases\Article\GetViewList;

class InputData implements InputPortInterface
{
    /**
     * @param string|null $q
     */
    public function __construct(private ?string $q)
    {
    }

    /**
     * @return string|null
     */
    public function getQuery(): ?string
    {
        return $this->q;
    }
}
