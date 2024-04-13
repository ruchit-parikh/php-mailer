<?php

namespace Tests;

use Mailer\Contracts\Response;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\AssertionFailedError;

class TestResponse
{
    /**
     * @var Response
     */
    protected Response $response;

    /**
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @param array $data
     *
     * @return static
     */
    public function assertJson(array $data): static
    {
        $response = json_decode($this->response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new AssertionFailedError('Invalid JSON was returned from the route');
        }

        Assert::assertTrue($response == $data, 'The response doesnt matches expected results!');

        return $this;
    }
}
