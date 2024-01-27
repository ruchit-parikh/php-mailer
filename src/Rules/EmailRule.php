<?php

namespace Mailer\Rules;

use Mailer\Contracts\Rule;

class EmailRule extends Rule
{
    /**
     * @inheritDoc
     */
    public function validate(): bool
    {
        return filter_var($this->value, FILTER_VALIDATE_EMAIL);
    }

    /**
     * @inheritDoc
     */
    public function message(): string
    {
        return "The field {$this->name} must be a valid email";
    }
}
