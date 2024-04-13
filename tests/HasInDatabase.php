<?php

namespace Tests;

use Mailer\Contracts\Model;
use PHPUnit\Framework\Constraint\Constraint;

class HasInDatabase extends Constraint
{
    /**
     * The data that will be used to narrow the search in the database table.
     *
     * @var array
     */
    protected array $data;

    /**
     * Create a new constraint instance.
     *
     * @param array $data
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Check if the data is found in the given table.
     *
     * @param string|Model $other
     *
     * @return bool
     */
    public function matches($other): bool
    {
        $query = $other::getInstance();

        foreach ($this->data as $key => $value) {
            $query->where($key, $value);
        }

        return !is_null($query->first());
    }

    /**
     * Get the description of the failure.
     *
     * @param string|Model $other
     *
     * @return string
     */
    public function failureDescription($other): string
    {
        return sprintf(
            "a row in the table [%s] with the attributes %s matches any record",
            $other::getInstance()->getTableName(),
            $this->toString(JSON_PRETTY_PRINT)
        );
    }

    /**
     * Get a string representation of the object.
     *
     * @param int $options
     *
     * @return string
     */
    public function toString(int $options = 0): string
    {
        return json_encode($this->data, $options);
    }
}
