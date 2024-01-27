<?php

namespace App\Subscribers\Exceptions;

use App\Subscribers\Entities\Subscriber;
use Mailer\Http\Request;
use Throwable;

class SubscriberAlreadyExistsException extends \Exception
{
    /**
     * @param Subscriber $subscriber
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(Subscriber $subscriber, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(trim($message) == "" ? "The email {$subscriber->getEmail()} used for subscriber you are creating already exists" : $message, Request::UNPROCESSABLE_ENTITY, $previous);
    }
}
