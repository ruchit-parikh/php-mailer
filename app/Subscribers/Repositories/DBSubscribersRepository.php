<?php

namespace App\Subscribers\Repositories;

use App\Subscribers\Entities\Subscriber;
use App\Subscribers\Models\Subscriber as SubscriberModel;
use App\Subscribers\Repositories\Contracts\SubscribersRepository;
use Mailer\Contracts\PaginatedCollection;

class DBSubscribersRepository implements SubscribersRepository
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

    protected function __construct()
    {
        // You can't create repositories on your own
    }

    /**
     * @inheritDoc
     */
    public function getPaginated(array $filters = []): PaginatedCollection
    {
        return SubscriberModel::getInstance()
            ->query()
            ->get($filters['limit'], $filters['page']);
    }

    /**
     * @inheritDoc
     */
    public function find(int $id): ?Subscriber
    {
        return SubscriberModel::getInstance()
            ->query()
            ->where('id', $id)
            ->first();
    }

    /**
     * @inheritDoc
     */
    public function findByEmail(string $email): ?Subscriber
    {
        return SubscriberModel::getInstance()
            ->query()
            ->where('email', $email)
            ->first();
    }

    /**
     * @inheritDoc
     */
    public function store(Subscriber $subscriber): int
    {
        return SubscriberModel::getInstance()
            ->query()
            ->insert([
                'email'         => $subscriber->getEmail(),
                'first_name'    => $subscriber->getFirstName(),
                'last_name'     => $subscriber->getLastName(),
                'status'        => $subscriber->getStatus(),
                'subscribed_at' => $subscriber->getSubscribedAt()->format('Y-m-d H:i:s'),
            ]);
    }
}
