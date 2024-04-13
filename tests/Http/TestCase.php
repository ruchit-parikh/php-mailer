<?php

namespace Tests\Http;

use Mailer\Contracts\Request as BaseRequest;
use Mailer\Http\Kernel;
use Mailer\Http\Request;
use Tests\TestCase as BaseTestCase;
use Tests\TestResponse;

class TestCase extends BaseTestCase
{
    /**
     * @var Kernel
     */
    protected static $kernel;

    /**
     * @param string $uri
     * @param array  $query
     *
     * @throws \Exception
     *
     * @return TestResponse
     */
    protected function jsonGet(string $uri, array $query = []): TestResponse
    {
        $server = ['REQUEST_METHOD' => 'GET', 'PHP_SELF' => $uri, 'CONTENT-TYPE' => 'application/json'];

        return $this->serve(new Request($query, [], [], $server));
    }

    /**
     * @param string $uri
     * @param array  $data
     * @param array  $files
     *
     * @throws \Exception
     *
     * @return TestResponse
     */
    protected function jsonPost(string $uri, array $data = [], array $files = []): TestResponse
    {
        $server = ['REQUEST_METHOD' => 'POST', 'PHP_SELF' => $uri, 'CONTENT_TYPE' => !count($files) ? 'application/x-www-form-urlencoded' : 'multipart/form-data'];

        return $this->serve(new Request([], $data, $files, $server));
    }

    /**
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        if (!static::$kernel) {
            $kernel = Kernel::getInstance();

            $kernel->bootstrap();

            static::$kernel = $kernel;
        }

        parent::setUpBeforeClass();
    }

    /**
     * @inheritDoc
     *
     * @throws \Exception
     */
    protected function serve(Request|BaseRequest $request): TestResponse
    {
        $kernel = static::$kernel;

        $response = $kernel->handle($request);

        return new TestResponse($response);
    }
}
