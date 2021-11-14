<?php

namespace App\Models\Domains\Article;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class IndexViewModel
{
    public function __construct(public LengthAwarePaginator $articles, public ?string $q)
    {
    }
}
