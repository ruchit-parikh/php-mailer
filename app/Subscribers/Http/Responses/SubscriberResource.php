<?php

namespace App\Subscribers\Http\Responses;

use App\Subscribers\Entities\Subscriber;
use Mailer\Http\JsonResponse;

class SubscriberResource extends JsonResponse
{
    /**
     * @inheritDoc
     */
    public function collect(): array
    {
        /** @var Subscriber $resource */
        $resource = $this->resource;

        return [
            'id'            => $resource->getId(),
            'first_name'    => $resource->getFirstName(),
            'last_name'     => $resource->getLastName(),
            'email'         => $resource->getEmail(),
            'status_label'  => $resource->getStatusLabel(),
            'status_color'  => $resource->getStatusColor(),
            'status'        => $resource->getStatus(),
            'subscribed_at' => $resource->getSubscribedAt()->format('Y-m-d H:i:s'),
        ];
    }
}
