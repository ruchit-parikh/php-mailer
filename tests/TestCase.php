<?php

namespace Tests;

use Mailer\Contracts\Request;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * @param Request $request
     *
     * @return TestResponse
     */
    abstract protected function serve(Request $request): TestResponse;

    /**
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        if (!defined('ENV')) {
            define('ENV', 'test');
        }

        parent::setUpBeforeClass();
    }
}
