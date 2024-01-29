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
        return !is_null($this->value) && trim($this->value) !== '' && (!is_array($this->value) || count($this->value));
    }

    /**
     * @inheritDoc
     */
    public function message(): string
    {
        return "The field {$this->name} is required";
    }
}
