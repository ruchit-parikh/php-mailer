<?php

namespace Mailer\Http;

use Mailer\Contracts\PaginatedCollection;

abstract class ResourceCollection extends JsonResponse
{
    /**
     * @var JsonResponse[]
     */
    protected array $collection;

    /**
     * @var array
     */
    protected array $meta;

    /**
     * @var string
     */
    protected static string $collects = JsonResponse::class;

    /**
     * @param PaginatedCollection $collection
     */
    public function __construct(PaginatedCollection $collection)
    {
        $this->collection = $this->collectResources($collection->getData());

        $this->meta = ['total' => $collection->getTotalItems(), 'pages' => ['next' => $collection->getNextPage(), 'prev' => $collection->getPrevPage(), 'total' => $collection->getTotalPages()]];

        parent::__construct($this->collect());
    }

    /**
     * @param array $data
     *
     * @return array
     */
    protected function collectResources(array $data): array
    {
        $resources = [];

        foreach ($data as $record) {
            $resources[] = new static::$collects($record);
        }

        return $resources;
    }
}
