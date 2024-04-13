<?php

namespace App\Subscribers\Repositories\Contracts;

use App\Subscribers\Entities\Subscriber;
use Mailer\Contracts\PaginatedCollection;

interface SubscribersRepository
{
    /**
     * @param array $filters
     *
     * @return PaginatedCollection
     */
    public function getPaginated(array $filters = []): PaginatedCollection;

    /**
     * @param int $id
     *
     * @return Subscriber|null
     */
    public function find(int $id): ?Subscriber;

    /**
     * @param string $email
     *
     * @return Subscriber|null
     */
    public function findByEmail(string $email): ?Subscriber;

    /**
     * @param Subscriber $subscriber
     *
     * @return int
     */
    public function store(Subscriber $subscriber): int;
}
