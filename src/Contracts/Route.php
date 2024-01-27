<?php

namespace Mailer\Contracts;

class Route
{
    /**
     * @var string
     */
    private string $controllerClass;

    /**
     * @var string
     */
    private string $method;

    /**
     * @var string
     */
    private string $requestClass;

    /**
     * @var array
     */
    private array $params;

    /**
     * @param string $controller
     * @param string $method
     * @param string $request
     * @param array  $params
     */
    public function __construct(string $controller, string $method, string $request, array $params = [])
    {
        $this->controllerClass = $controller;
        $this->method          = $method;
        $this->requestClass    = $request;
        $this->params          = $params;
    }

    /**
     * @return string
     */
    public function getControllerClass(): string
    {
        return $this->controllerClass;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getRequestClass(): string
    {
        return $this->requestClass;
    }

    /**
     * @param array $params
     *
     * @return $this
     */
    public function setParams(array $params): static
    {
        $this->params = $params;

        return $this;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}
