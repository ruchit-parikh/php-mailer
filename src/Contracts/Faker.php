<?php

namespace Mailer\Contracts;

abstract class Faker
{
    /**
     * @var static
     */
    protected static $instance;

    /**
     * @return $this
     */
    public static function getInstance(): static
    {
        if (static::$instance) {
            return static::$instance;
        }

        return static::$instance = new static();
    }

    /**
     * @param int $count
     *
     * @return Entity[]
     */
    public function fakeInFresh(int $count): array
    {
        $this->truncate();

        return $this->fake($count);
    }

    /**
     * @return bool
     */
    abstract public function truncate(): bool;

    /**
     * @param int $count
     *
     * @return Entity[]
     */
    public function fake(int $count): array
    {
        $entities = [];

        for ($i = 0; $i < $count; ++$i) {
            $entities[] = $this->fakeSingle(['key' => $i + 1]);
        }

        return $entities;
    }

    /**
     * @param array $overrides
     *
     * @return Entity
     */
    abstract public function fakeSingle(array $overrides = []): Entity;

    /**
     * @param array $overrides
     *
     * @return Entity
     */
    public function fakeSingleInFresh(array $overrides = []): Entity
    {
        $this->truncate();

        return $this->fakeSingle($overrides);
    }
}
