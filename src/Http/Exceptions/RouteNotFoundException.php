<?php

namespace Mailer\Http\Exceptions;

use Mailer\Http\Request;
use Throwable;

class RouteNotFoundException extends \Exception
{
    /**
     * @var string
     */
    protected string $route;

    /**
     * @param string         $route
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(string $route, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        $this->route = $route;

        parent::__construct(trim($message) == "" ? sprintf("The route :%s that you are looking for does not exists", $this->route) : $message, Request::HTTP_NOT_FOUND, $previous);
    }
}
