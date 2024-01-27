<?php

namespace Mailer\Database;

class MySQLDatabaseDriver extends RelationalDatabaseDriver
{
    /**
     * @inheritDoc
     */
    public function getDsnString(array $config): string
    {
        $dsn = "mysql:host={$config['host']};dbname={$config['database']}";

        if (isset($config['port'])) {
            $dsn .= ";port={$config['port']}";
        }

        return $dsn;
    }
}
