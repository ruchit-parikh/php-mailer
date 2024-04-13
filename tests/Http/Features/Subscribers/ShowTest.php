<?php

namespace Tests\Http\Features\Subscribers;

use App\Subscribers\Entities\Subscriber;
use App\Subscribers\Exceptions\SubscriberNotFoundException;
use App\Subscribers\Fakers\SubscriberFaker;
use Tests\Http\TestCase;

class ShowTest extends TestCase
{
    /**
     * @test
     */
    public function show_subscriber_when_exist()
    {
        /** @var Subscriber $subscriber */
        $subscriber = SubscriberFaker::getInstance()->fakeSingleInFresh();

        $this->jsonGet("/subscribers/{$subscriber->getId()}")
            ->assertJson([
                'id'            => $subscriber->getId(),
                'first_name'    => $subscriber->getFirstName(),
                'last_name'     => $subscriber->getLastName(),
                'email'         => $subscriber->getEmail(),
                'status_label'  => $subscriber->getStatusLabel(),
                'status_color'  => $subscriber->getStatusColor(),
                'status'        => $subscriber->getStatus(),
                'subscribed_at' => $subscriber->getSubscribedAt()->format('Y-m-d H:i:s'),
            ]);
    }

    /**
     * @test
     */
    public function show_subscriber_when_not_exist_gives_exception()
    {
        SubscriberFaker::getInstance()->truncate();

        $this->expectException(SubscriberNotFoundException::class);

        $this->jsonGet('/subscribers/1');
    }
}
