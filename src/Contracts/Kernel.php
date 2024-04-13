<?php

namespace Mailer\Contracts;

abstract class Kernel
{
    /**
     * @var static
     */
    protected static $instance;

    /**
     * @return $this
     */
    public static function getInstance(): static
    {
        if (static::$instance) {
            return static::$instance;
        }

        return static::$instance = new static();
    }

    /**
     * @return void
     */
    protected function __construct()
    {
        // You can't create kernel on your own
    }

    /**
     * @return void
     */
    abstract public function bootstrap(): void;

    /**
     * @param Request $request
     *
     * @return Response
     */
    abstract public function handle(Request $request): Response;

    /**
     * @param Response $response
     *
     * @return void
     */
    public function terminate(Response $response): void
    {
        echo $response;

        exit(0);
    }
}
