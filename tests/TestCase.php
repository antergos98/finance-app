<?php

namespace Tests;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use LazilyRefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // We don't want defers in our tests
        $this->withoutDefer();
    }
}
