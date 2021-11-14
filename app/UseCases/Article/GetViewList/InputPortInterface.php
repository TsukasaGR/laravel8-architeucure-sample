<?php

namespace App\UseCases\Article\GetViewList;

interface InputPortInterface
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
