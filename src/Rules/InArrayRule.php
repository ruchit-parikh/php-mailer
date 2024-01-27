<?php

namespace Mailer\Rules;

use Mailer\Contracts\Rule;

class InArrayRule extends Rule
{
    /**
     * @inheritDoc
     */
    public function validate(): bool
    {
        return in_array($this->value, $this->params[0]);
    }

    /**
     * @inheritDoc
     */
    public function message(): string
    {
        return "The field {$this->name} must be in valid possible values";
    }
}
