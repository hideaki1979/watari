<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends BaseTestCase
{
    //
    use CreatesApplication;
    use RefreshDatabase;    // 各テスト実行時にDBをリフレッシュ

    protected function serUp(): void {
        parent::setUp();
        // 共通のセットアップ処理があればここに記述
    }
}
