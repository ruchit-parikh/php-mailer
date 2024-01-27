<?php

namespace Mailer\Http;

use JsonSerializable;

class JsonResponse extends Response implements JsonSerializable
{
    /**
     * @var mixed
     */
    protected mixed $resource;

    /**
     * @param mixed $data
     */
    public function __construct(mixed $data)
    {
        $this->resource = $data;

        $this->addHeader('Content-Type', 'application/json')
            ->addHeader('Access-Control-Allow-Origin', '*');

        parent::__construct(json_encode($this->collect(), JSON_PRETTY_PRINT));
    }

    /**
     * @return array
     */
    public function collect(): array
    {
        return $this->resource;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->collect();
    }
}
