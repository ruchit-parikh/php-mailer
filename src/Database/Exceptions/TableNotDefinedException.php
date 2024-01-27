<?php

namespace Mailer\Database\Exceptions;

use Throwable;

class TableNotDefinedException extends \Exception
{
    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(trim($message) == "" ? "The table is not specified" : $message, $code, $previous);
    }
}
