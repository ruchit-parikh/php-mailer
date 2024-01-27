<?php

namespace Mailer\Http;

use Mailer\Contracts\Response as BaseResponse;

class Response extends BaseResponse
{
    /**
     * @var array
     */
    protected array $headers;

    /**
     * @param string $data
     */
    public function __construct(string $data)
    {
        $this->headers['Cache-Control'] = 'no-cache, no-store, must-revalidate';

        parent::__construct($data);
    }

    /**
     * @param string $header
     * @param string $value
     *
     * @return $this
     */
    public function addHeader(string $header, string $value): static
    {
        $this->headers[$header] = $value;

        return $this;
    }

    /**
     * @return array|string[]
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }
}
