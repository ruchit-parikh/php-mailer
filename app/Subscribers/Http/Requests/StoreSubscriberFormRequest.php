<?php

namespace App\Subscribers\Http\Requests;

use App\Subscribers\Entities\Subscriber;
use Mailer\Http\FormRequest;
use Mailer\Rules\EmailRule;
use Mailer\Rules\InArrayRule;
use Mailer\Rules\RequiredRule;

class StoreSubscriberFormRequest extends FormRequest
{
    /**
     * @inheritDoc
     */
    protected function rules(): array
    {
        return [
            'first_name' => [RequiredRule::class],
            'last_name' => [RequiredRule::class],
            'email' => [RequiredRule::class, EmailRule::class],
            'status' => [RequiredRule::class, new InArrayRule(Subscriber::getPossibleStatus())]
        ];
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->post('first_name');
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->post('last_name');
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->post('email');
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->post('status');
    }
}
