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
        if (is_null($this->value)) {
            return false;
        }

        if (is_array($this->value)) {
            return count($this->value) > 0;
        }

        return trim($this->value) !== '';
    }

    /**
     * @inheritDoc
     */
    public function message(): string
    {
        return "The field {$this->name} is required";
    }
}
