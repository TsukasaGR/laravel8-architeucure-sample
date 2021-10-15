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
        // 毎回実行すると遅すぎるのでテスト前にCI等でリセットしたほうが良い
//        Artisan::call('migrate:fresh');
    }
}
