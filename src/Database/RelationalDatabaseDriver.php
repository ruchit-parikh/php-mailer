<?php

namespace Mailer\Database;

use Mailer\Contracts\DatabaseDriver;
use Mailer\Database\Exceptions\TableNotDefinedException;
use Mailer\Database\Exceptions\UnprocessableQuery;
use PDO;

abstract class RelationalDatabaseDriver implements DatabaseDriver
{
    /**
     * @var string
     */
    protected string $quoteChar = '`';

    /**
     * @var string
     */
    protected string $quoteValueChar = '"';

    /**
     * @inheritDoc
     */
    public function makeConnection(array $config): PDO
    {
        $dsn = $this->getDsnString($config);

        return new PDO($dsn, $config['username'], $config['password'], []);
    }

    /**
     * @param array $config
     *
     * @return string
     */
    abstract public function getDsnString(array $config): string;

    /**
     * @inheritDoc
     *
     * @throws TableNotDefinedException|UnprocessableQuery
     */
    public function query(array $parts): string
    {
        if (empty($parts['table'])) {
            throw new TableNotDefinedException;
        }

        if (isset($parts['insert']) && $parts['insert']) {
            return $this->buildInsertQuery($parts);
        }

        if (isset($parts['delete']) && $parts['delete']) {
            return $this->buildDeleteQuery($parts);
        }

        //TODO: We may need to add other queries like update etc

        return $this->buildSelectQuery($parts);
    }

    /**
     * @param array $parts
     *
     * @throws UnprocessableQuery
     *
     * @return string
     */
    protected function buildInsertQuery(array $parts): string
    {
        if (empty($parts['columns'])) {
            throw new UnprocessableQuery($parts);
        }

        $query = 'INSERT INTO %s (%s) VALUES (%s)';

        return sprintf(
            $query,
            $this->quote($parts['table']),
            implode(',', $this->quote($parts['columns'])),
            rtrim(str_repeat('?,', count($parts['columns'])), ',')
        );
    }

    /**
     * @param array $parts
     *
     * @return string
     */
    protected function buildDeleteQuery(array $parts): string
    {
        $query = 'DELETE FROM %s';

        if (isset($parts['wheres']) && count($parts['wheres'])) {
            $query .= $this->getWhereQueryString($parts['wheres']);
        }

        return sprintf($query, $this->quote($parts['table']));
    }

    /**
     * @param array $parts
     *
     * @return string
     */
    protected function buildSelectQuery(array $parts): string
    {
        $query = '';

        if (!isset($parts['selects']) || count($parts['selects']) < 1) {
            $query = sprintf('SELECT * FROM %s', $this->quote($parts['table']));
        } else {
            $query = sprintf('SELECT %s FROM %s', implode('', $this->quote($parts['selects'])), $this->quote($parts['table']));
        }

        if (isset($parts['wheres']) && count($parts['wheres'])) {
            $query .= $this->getWhereQueryString($parts['wheres']);
        }

        if (isset($parts['limit']) && $parts['limit'] > 0) {
            if (isset($parts['page']) && $parts['page'] > 0) {
                $query .= sprintf(' LIMIT %s OFFSET %s', (int) $parts['limit'], (int) ($parts['page'] - 1) * $parts['limit']);
            } else {
                $query .= sprintf(' LIMIT %s', $parts['limit']);
            }
        }

        return $query;
    }

    /**
     * @param array $whereGroups
     *
     * @return string
     */
    private function getWhereQueryString(array $whereGroups): string
    {
        $whereParts = [];

        foreach ($whereGroups as $relation => $wheres) {
            $quotedWheres = [];

            foreach ($wheres as $where) {
                $quotedWheres[] = strtoupper($relation) . ' ' . $this->quote($where['column']) . ' ' . $where['operator'] . ' ' . $this->quoteValue($where['value']);
            }

            $whereParts[] = implode(' ', $quotedWheres);
        }

        return sprintf(' WHERE %s', ltrim(implode(' ', $whereParts), strtoupper(array_key_first($whereGroups)) . ' '));
    }

    /**
     * @param string|array $value
     *
     * @return string|array
     */
    private function quote(string|array $value): string|array
    {
        return $this->quoteWithChar($value, $this->quoteChar);
    }

    /**
     * @param string|array $value
     *
     * @return string|array
     */
    private function quoteValue(string|array $value): string|array
    {
        return $this->quoteWithChar($value, $this->quoteValueChar);
    }

    /**
     * @param string|array $value
     * @param string       $char
     *
     * @return string|array
     */
    private function quoteWithChar(string|array $value, string $char): string|array
    {
        if (is_array($value)) {
            $quoted = [];

            foreach ($value as $single) {
                $quoted[] = $this->isQuoteExcludedKeyword($single) ? $single : sprintf($char . '%s' . $char, $single);
            }

            return $quoted;
        } else {
            return $this->isQuoteExcludedKeyword($value) ? $value : sprintf($char . '%s' . $char, $value);
        }
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    private function isQuoteExcludedKeyword(string $value): bool
    {
        $sqlKeywords = array_map('strtoupper', $this->getQuoteExcludedKeywords());

        // Keywords that will be excluded for quote
        $regex = '/\b(' . implode('|', array_map('preg_quote', $sqlKeywords)) . ')\b/i';

        return preg_match($regex, strtoupper($value));
    }

    /**
     * @return array
     */
    protected function getQuoteExcludedKeywords(): array
    {
        return ['COUNT', 'MIN', 'MAX', 'SELECT'];
    }
}
