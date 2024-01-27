<?php

namespace Mailer\Rules;

use Mailer\Contracts\Rule;

class RequiredRule extends Rule
{
    /**
     * @inheritDoc
     */
    public function validate(): bool
    {
        return !empty($this->value);
    }

    /**
     * @inheritDoc
     */
    public function message(): string
    {
        return "The field {$this->name} is required";
    }
}
