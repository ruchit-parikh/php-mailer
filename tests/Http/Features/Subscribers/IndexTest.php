<?php

namespace Tests\Http\Features\Subscribers;

use App\Subscribers\Entities\Subscriber;
use App\Subscribers\Fakers\SubscriberFaker;
use Tests\Http\TestCase;

class IndexTest extends TestCase
{
    /**
     * @var Subscriber[]
     */
    private static array $subscribers = [];

    /**
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        /** @var Subscriber[] $subscribers */
        $subscribers = SubscriberFaker::getInstance()->fakeInFresh(100);

        foreach ($subscribers as $subscriber) {
            static::$subscribers[] = [
                'id'            => $subscriber->getId(),
                'first_name'    => $subscriber->getFirstName(),
                'last_name'     => $subscriber->getLastName(),
                'email'         => $subscriber->getEmail(),
                'status_label'  => $subscriber->getStatusLabel(),
                'status_color'  => $subscriber->getStatusColor(),
                'status'        => $subscriber->getStatus(),
                'subscribed_at' => $subscriber->getSubscribedAt()->format('Y-m-d H:i:s'),
            ];
        }
    }

    /**
     * @test
     */
    public function list_subscribers_first_page()
    {
        $this->jsonGet('/subscribers', ['page' => 1, 'limit' => 10])
            ->assertJson([
                'data' => array_slice(static::$subscribers, 0, 10),
                'meta' => [
                    'total' => '100',
                    'pages' => [
                        'next'  => '2',
                        'prev'  => null,
                        'total' => '10',
                    ],
                ],
            ]);
    }

    /**
     * @test
     */
    public function list_subscribers_third_page()
    {
        $this->jsonGet('/subscribers', ['page' => 3, 'limit' => 10])
            ->assertJson([
                'data' => array_slice(static::$subscribers, 20, 10),
                'meta' => [
                    'total' => '100',
                    'pages' => [
                        'next'  => '4',
                        'prev'  => '2',
                        'total' => '10',
                    ],
                ],
            ]);
    }
}
