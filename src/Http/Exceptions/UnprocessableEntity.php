<?php

namespace Mailer\Http\Exceptions;

use Mailer\Http\Request;
use Throwable;

class UnprocessableEntity extends \Exception
{
    /**
     * @var array
     */
    protected array $errors;

    /**
     * @param array          $errors
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(array $errors, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        $this->errors = $errors;

        parent::__construct(trim($message) == "" ? "There are some errors in data you submitted" : $message, Request::UNPROCESSABLE_ENTITY, $previous);
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
