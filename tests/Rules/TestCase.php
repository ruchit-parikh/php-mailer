<?php

namespace Tests\Rules;

use Mailer\Contracts\Rule;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * @param Rule  $rule
     * @param mixed $value
     *
     * @return static
     */
    public function assertValid(Rule $rule, $value): static
    {
        $rule->setValue($value);

        Assert::assertTrue($rule->validate(), sprintf('Failed to assert %s as valid', json_encode($value)));

        return $this;
    }

    /**
     * @param Rule  $rule
     * @param mixed $value
     *
     * @return static
     */
    public function assertInValid(Rule $rule, $value): static
    {
        $rule->setValue($value);

        Assert::assertFalse($rule->validate(), sprintf('Failed to assert %s as invalid', json_encode($value)));

        return $this;
    }
}
