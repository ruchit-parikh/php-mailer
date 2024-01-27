<?php

namespace Mailer\Database\Exceptions;

use Throwable;

class UnprocessableQuery extends \Exception
{
    /**
     * @var array
     */
    protected array $parts;

    /**
     * @param array          $parts
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(array $parts, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        $this->parts = $parts;

        parent::__construct(trim($message) == "" ? "The query you defined is not processable" : $message, $code, $previous);
    }
}
