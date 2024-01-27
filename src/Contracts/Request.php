<?php

namespace Mailer\Contracts;

abstract class Request
{
    /**
     * @return void
     */
    abstract public function collectData(): void;
}
