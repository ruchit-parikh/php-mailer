<?php

namespace Mailer\Contracts;

class PaginatedCollection
{
    /**
     * @var Entity[]|array
     */
    protected array $data;

    /**
     * @var int
     */
    protected int $page;

    /**
     * @var int
     */
    protected int $limit;

    /**
     * @var int
     */
    protected int $total;

    /**
     * @param array $data
     * @param int   $page
     * @param int   $limit
     * @param int   $total
     */
    public function __construct(array $data, int $page, int $limit, int $total)
    {
        $this->data  = $data;
        $this->page  = $page;
        $this->limit = $limit;
        $this->total = $total;
    }

    /**
     * @return Entity[]|array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return int|null
     */
    public function getNextPage(): ?int
    {
        $totalPages = $this->getTotalPages();

        if ($this->page >= $totalPages) {
            return null;
        }


        if ($this->page < 1) {
            return 1;
        }

        return $this->page + 1;
    }

    /**
     * @return int|null
     */
    public function getPrevPage(): ?int
    {
        if ($this->page <= 1) {
            return null;
        }

        $totalPages = $this->getTotalPages();

        if ($this->page > $totalPages) {
            return $totalPages;
        }

        return $this->page - 1;
    }

    /**
     * @return int
     */
    public function getTotalItems(): int
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function getTotalPages(): int
    {
        return ceil($this->total / $this->limit);
    }
}
