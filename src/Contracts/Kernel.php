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
        if (static::$instance)
        {
            return static::$instance;
        }

        return static::$instance = new static();
    }

    /**
     * @var Router
     */
    protected Router $router;

    /**
     * @var Request
     */
    protected Request $request;

    protected function __construct()
    {
        $routerClass = $this->getRouterClass();
        $this->router = new $routerClass;

        $requestClass = $this->getRequestClass();
        $this->request = new $requestClass;
    }

    /**
     * @return string
     */
    abstract protected function getRouterClass(): string;

    /**
     * @return string
     */
    abstract protected function getRequestClass(): string;

    /**
     * @return void
     */
    public function bootstrap(): void
    {
        $this->router->registerRoutes();

        $this->request->collectData();
    }

    /**
     * @return Router
     */
    public function getRouter(): Router
    {
        return $this->router;
    }

    /**
     * @return Response
     */
    abstract public function serve(): Response;

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
