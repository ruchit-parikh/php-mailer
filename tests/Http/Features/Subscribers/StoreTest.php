<?php

namespace Tests\Http\Features\Subscribers;

use App\Subscribers\Exceptions\SubscriberAlreadyExistsException;
use App\Subscribers\Fakers\SubscriberFaker;
use Tests\Http\TestCase;

class StoreTest extends TestCase
{
    /**
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        SubscriberFaker::getInstance()->truncate();

        parent::setUpBeforeClass();
    }

    /**
     * @test
     */
    public function store_new_subscriber_with_new_email()
    {
        $this->jsonPost('/subscribers', [
                'first_name' => 'John',
                'last_name'  => 'Doe',
                'email'      => 'johndoe@gmail.com',
                'status'     => '1',
            ])
            ->assertJson(['message' => 'Subscriber created successfully.']);
    }

    /**
     * @test
     */
    public function store_new_subscriber_with_existing_email_gives_exception()
    {
        SubscriberFaker::getInstance()->fakeSingleInFresh([
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'email'      => 'johndoe2@gmail.com',
            'status'     => '1',
        ]);

        $this->expectException(SubscriberAlreadyExistsException::class);

        $this->jsonPost('/subscribers', [
            'first_name' => 'John',
            'last_name'  => 'Doe2',
            'email'      => 'johndoe2@gmail.com',
            'status'     => '0',
        ]);
    }
}
