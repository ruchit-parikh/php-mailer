<?php

namespace Mailer\Contracts;

class Entity
{
    /**
     * @var array
     */
    protected array $attributes;

    /**
     * @var array
     */
    protected array $types = [];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $field => $attribute) {
            $this->$field = $attribute;
        }
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function __get(string $key): mixed
    {
        return $this->attributes[$key];
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return void
     */
    public function __set(string $key, mixed $value): void
    {
        if (isset($this->types[$key])) {
            $type = $this->types[$key];

            $this->attributes[$key] = $value instanceof $type ? $value : new $type($value);
        } else {
            $this->attributes[$key] = $value;
        }
    }
}
