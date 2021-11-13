<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * ランダムかつ有効なURLを生成する
     * faker->url()で生成したいが、validationのactive_urlを通らない値を返す場合があるためこちらを利用している
     * @return string
     */
    public function activeRandomUrl(): string
    {
        $randomStr = rand(1, 9999);
        return "https://example.com/{$randomStr}";
    }
}
