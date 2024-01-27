<?php

namespace Mailer\Contracts;

abstract class Router
{
    /**
     * @var Route[]
     */
    protected array $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    /**
     * @return void
     */
    abstract function registerRoutes(): void;
}
