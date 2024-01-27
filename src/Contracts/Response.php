<?php

namespace Mailer\Contracts;

class Response
{
    /**
     * @var string
     */
    protected string $content;

    /**
     * @param string $data
     */
    public function __construct(string $data)
    {
        $this->content = $data;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->content;
    }
}
