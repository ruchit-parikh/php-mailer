<?php

namespace Mailer\Contracts;

use PDO;

class Database
{
    /**
     * @var PDO
     */
    protected PDO $pdo;

    /**
     * @var DatabaseDriver
     */
    protected DatabaseDriver $driver;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        /** @var DatabaseDriver $driver */
        $driver = new $config['db_driver'];

        // We are holding this connection to avoid connecting on every query
        // As of now its only for relational db with PDO; we can change it internally as not exposed when needed for support of NoSQL
        $this->pdo = $driver->makeConnection($config);

        $this->driver = $driver;
    }

    /**
     * @param string $query
     * @param array  $bindings
     *
     * @return bool
     */
    public function execute(string $query, array $bindings = []): bool
    {
        $stmt = $this->pdo->prepare($query);

        foreach ($bindings as $key => $value) {
            $stmt->bindValue((int) $key + 1, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }

        return $stmt->execute();
    }

    /**
     * @param string $query
     *
     * @return null|array
     */
    public function fetchAll(string $query): ?array
    {
        $stmt = $this->pdo->prepare($query);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param string $query
     *
     * @return mixed
     */
    public function fetch(string $query): mixed
    {
        $stmt = $this->pdo->prepare($query);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @return int
     */
    public function lastInsertedId(): int
    {
        return $this->pdo->lastInsertId();
    }

    /**
     * @return DatabaseDriver
     */
    public function getDriver(): DatabaseDriver
    {
        return $this->driver;
    }
}
