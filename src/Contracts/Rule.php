<?php

namespace Mailer\Contracts;

abstract class Rule
{
    /**
     * @var string
     */
    protected string $name;

    /**
     * @var mixed
     */
    protected mixed $value;

    /**
     * @var array
     */
    protected array $params;

    /**
     * @param mixed ...$args
     */
    public function __construct(...$args)
    {
        $this->params = $args;
    }

    /**
     * @return bool
     */
    abstract public function validate(): bool;

    /**
     * @return string
     */
    abstract public function message(): string;

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setFieldName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string|null $value
     *
     * @return $this
     */
    public function setValue(?string $value): static
    {
        $this->value = $value;

        return $this;
    }
}
