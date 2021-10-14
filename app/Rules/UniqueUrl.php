<?php

namespace App\Rules;

use App\Models\Article;
use Illuminate\Contracts\Validation\Rule;

/**
 * クエリストリング及びURLフラグメントを省いた状態で重複したURLがないかをチェックするバリデーションルール
 */
class UniqueUrl implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $articles = Article::all();
        $urls = $articles->pluck('url');
        $urlsExcludedQueryAndFlag = $urls->map(function ($url) {
            return $this->getUrlExcludedQueryAndFlag($url);
        });
        $valueExcludedQueryAndFlag = $this->getUrlExcludedQueryAndFlag($value);

        return ! $urlsExcludedQueryAndFlag->contains(function ($urlExcludeQuery) use ($valueExcludedQueryAndFlag) {
            return $urlExcludeQuery === $valueExcludedQueryAndFlag;
        });
    }

    /**
     * 引数のURLからクエリストリングをURLフラグメントを除外したURL部分のみを返す
     * @param string $url
     * @return string
     */
    private function getUrlExcludedQueryAndFlag(string $url): string
    {
        return explode('#', explode('?', $url)[0])[0];
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.custom.unique_url');
    }
}
