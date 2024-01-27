<?php

namespace App\Subscribers\Http\Responses;

use Mailer\Http\ResourceCollection;

class SubscribersCollection extends ResourceCollection
{
    protected static string $collects = SubscriberResource::class;

    /**
     * @inheritDoc
     */
    public function collect(): array
    {
        return [
            'data' => $this->collection,
            'meta' => $this->meta,
        ];
    }
}
