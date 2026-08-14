<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // CI runs `php artisan test` without a Node/npm build step, so the
        // admin layout's @vite directive has no manifest to resolve.
        $this->withoutVite();
    }
}
