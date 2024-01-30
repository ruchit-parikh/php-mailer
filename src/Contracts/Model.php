<?php

namespace Mailer\Contracts;

use DateTimeImmutable;

class Model
{
    /**
     * @var Database
     */
    protected Database $db;

    /**
     * @var string
     */
    protected string $table;

    /**
     * @var array
     */
    protected array $selects;

    /**
     * @var array
     */
    protected array $wheres;

    /**
     * @var int
     */
    protected int $defaultLimit = 10;

    /**
     * @var bool
     */
    protected bool $timestamps = true;

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
     * @var string
     */
    protected string $entity = Entity::class;

    protected function __construct()
    {
        //You can't create instance of this outside

        $config = require __DIR__ . '/../../configuration.php';

        $this->db = new Database($config);
    }

    /**
     * @param array|string $select
     *
     * @return $this
     */
    public function select(array|string $select): static
    {
        if (is_string($select) && strpos($select, ',')) {
            $this->selects = array_unique([...$this->selects, ...explode(',', $select)]);
        } elseif (is_string($select) && !in_array($select, $this->selects)) {
            $this->selects[] = $select;
        } else {
            $this->selects = array_unique([...$this->selects, ...$select]);
        }

        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     * @param string $operator
     *
     * @return $this
     */
    public function where(string $key, string $value, string $operator = '='): static
    {
        if (!isset($this->wheres['AND'])) {
            $this->wheres['and'] = [];
        }

        // TODO: Create separate class for set of where so that we can merge wheres based on relation of and, or, not
        $this->wheres['and'][$key] = ['column' => $key, 'value' => $value, 'operator' => $operator];

        return $this;
    }

    /**
     * @return $this
     */
    public function query(): static
    {
        $this->selects = [];
        $this->wheres  = [];

        return $this;
    }

    /**
     * @param int|null $limit
     * @param int|null $page
     *
     * @return PaginatedCollection
     */
    public function get(?int $limit, ?int $page): PaginatedCollection
    {
        $query = $this->db->getDriver()->query([
            'table'   => $this->table,
            'selects' => $this->selects,
            'wheres'  => $this->wheres,
            'limit'   => $limit ?? $this->defaultLimit,
            'page'    => $page ?? 1,
        ]);

        $results = $this->db->fetchAll($query);

        $entityClass = $this->entity;

        $entities = [];

        foreach ($results as $result) {
            $entities[] = new $entityClass($this->escape($result));
        }

        $query = $this->db->getDriver()->query([
            'table'   => $this->table,
            'selects' => ['COUNT(*) as count'],
            'wheres'  => $this->wheres,
        ]);

        $total = $this->db->fetch($query)['count'];

        return new PaginatedCollection($entities, $page ?? 1, $limit ?? $this->defaultLimit, $total);
    }

    /**
     * @return mixed
     */
    public function first(): mixed
    {
        $query = $this->db->getDriver()->query([
            'table'   => $this->table,
            'selects' => $this->selects,
            'wheres'  => $this->wheres,
            'limit'   => 1,
        ]);

        $result = $this->db->fetch($query);

        $entityClass = $this->entity;

        return $result ? new $entityClass($this->escape($result)) : null;
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    public function insert(array $data): bool
    {
        if (!count($data)) {
            return false;
        }

        if ($this->timestamps) {
            $now = new DateTimeImmutable;

            if (!isset($data['created_at'])) {
                $data['created_at'] = $now->format('Y-m-d H:i:s');
            }

            if (!isset($data['updated_at'])) {
                $data['updated_at'] = $now->format('Y-m-d H:i:s');
            }
        }

        $query = $this->db->getDriver()->query([
            'table'   => $this->table,
            'insert'  => true,
            'columns' => array_keys($data),
        ]);

        return $this->db->execute($query, array_values($data));
    }

    /**
     * @param array $record
     *
     * @return array
     */
    protected function escape(array $record): array
    {
        $escaped = [];

        foreach ($record as $key => $value) {
            $escaped[$key] = htmlspecialchars($value);
        }

        return $escaped;
    }
}
