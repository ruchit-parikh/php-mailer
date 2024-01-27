<?php

namespace Mailer\Contracts;

interface DatabaseDriver
{
    /**
     * @param array $config
     *
     * @return mixed
     */
    public function makeConnection(array $config): mixed;

    /**
     * @param array $parts
     *
     * @return string
     */
    public function query(array $parts): string;
}
