<?php

namespace Mailer\Contracts;

abstract class Request
{
    /**
     * @var array
     */
    protected array $paths = [];

    /**
     * @return static
     */
    abstract public static function prepareRequest(): static;

    /**
     * @param array $paths
     *
     * @return $this
     */
    public function setPaths(array $paths): static
    {
        $this->paths = $paths;

        return $this;
    }

    /**
     * @param string|null $key
     *
     * @return mixed
     */
    public function path(string $key = null): mixed
    {
        return $key ? $this->paths[$key] ?? null : $this->paths;
    }

    /**
     * @return string
     */
    public function getRouteIdentifier(): string
    {
        return implode('|', array_keys($this->paths));
    }
}
