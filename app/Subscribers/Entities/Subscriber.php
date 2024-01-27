<?php

namespace App\Subscribers\Entities;

use DateTimeImmutable;
use Mailer\Contracts\Entity;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property int $status
 * @property DateTimeImmutable $subscribed_at
 * @property DateTimeImmutable $created_at
 * @property DateTimeImmutable $updated_at
 */
class Subscriber extends Entity
{
    const STATUS_UNSUBSCRIBED = 0;
    const STATUS_SUBSCRIBED = 1;
    const STATUS_BLOCKED = 2;

    /**
     * @inheritdoc
     */
    protected array $types = [
        'subscribed_at' => DateTimeImmutable::class
    ];

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->last_name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getSubscribedAt(): DateTimeImmutable
    {
        return $this->subscribed_at;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getStatusLabel(): string
    {
        $possible = static::getPossibleStatusMeta();

        return $possible[$this->status]['label'];
    }

    /**
     * @return string
     */
    public function getStatusColor(): string
    {
        $possible = static::getPossibleStatusMeta();

        return $possible[$this->status]['color'];
    }

    /**
     * @return array
     */
    private static function getPossibleStatusMeta(): array
    {
        return [
            self::STATUS_SUBSCRIBED => ['label' => 'Subscribed', 'color' => '#00ff00'],
            self::STATUS_UNSUBSCRIBED => ['label' => 'Unsubscribed', 'color' => '#ffff00'],
            self::STATUS_BLOCKED => ['label' => 'Blocked', 'color' => '#ff0000'],
        ];
    }

    /**
     * @return array
     */
    public static function getPossibleStatus(): array
    {
        return array_keys(static::getPossibleStatusMeta());
    }
}
