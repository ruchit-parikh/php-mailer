<?php

namespace App\Subscribers\Fakers;

use App\Subscribers\Entities\Subscriber;
use App\Subscribers\Models\Subscriber as SubscriberModel;
use DateTimeImmutable;
use Mailer\Contracts\Faker;

class SubscriberFaker extends Faker
{
    /**
     * @inheritDoc
     */
    public function truncate(): bool
    {
        return SubscriberModel::getInstance()->delete();
    }

    /**
     * @inheritDoc
     */
    public function fakeSingle(array $overrides = []): Subscriber
    {
        $data = [
            'first_name'    => $overrides['first_name'] ?? 'Name',
            'last_name'     => $overrides['last_name'] ?? ('# ' . ($overrides['key'] ?? 1)),
            'email'         => $overrides['email'] ?? sprintf('email%d@example.com', ($overrides['id'] ?? $overrides['key'] ?? 1)),
            'status'        => $overrides['status'] ?? 1,
            'subscribed_at' => $overrides['subscribed_at'] ?? (new DateTimeImmutable)->format('Y-m-d H:i:s'),
        ];

        $data['id'] = $overrides['id'] ?? SubscriberModel::getInstance()->query()->insert($data);

        return new Subscriber($data);
    }
}
