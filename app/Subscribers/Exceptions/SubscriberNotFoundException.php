<?php

namespace App\Subscribers\Exceptions;

use Mailer\Http\Request;
use Throwable;

class SubscriberNotFoundException extends \Exception
{
    /**
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(trim($message) == "" ? "The subscriber you are looking for does not exists" : $message, Request::HTTP_NOT_FOUND, $previous);
    }
}
