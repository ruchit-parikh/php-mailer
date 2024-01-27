<?php

namespace Mailer\Contracts;

class Controller
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

    protected function __construct()
    {
        // You can't create controllers on your own
    }
}
