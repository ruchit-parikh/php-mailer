<?php

namespace Tests\Rules;

use Mailer\Rules\EmailRule;
use Mailer\Rules\InArrayRule;
use Mailer\Rules\RequiredRule;

class CoreRulesTest extends TestCase
{
    /**
     * @test
     */
    public function test_email_rule()
    {
        $rule = new EmailRule;

        $this->assertValid($rule, 'test@example.com');

        $this->assertInValid($rule, 'test@');
        $this->assertInValid($rule, 'test');
        $this->assertInValid($rule, '@test.com');
        $this->assertInValid($rule, 'test.com');
    }

    /**
     * @test
     */
    public function test_required_rule()
    {
        $rule = new RequiredRule;

        $this->assertValid($rule, 'Sample Test');
        $this->assertValid($rule, 'false');
        $this->assertValid($rule, ['Sample', 'Test']);
        $this->assertValid($rule, ['']);

        $this->assertInValid($rule, '');
        $this->assertInValid($rule, '  ');
        $this->assertInValid($rule, null);
        $this->assertInValid($rule, false);
        $this->assertInValid($rule, []);
    }

    /**
     * @test
     */
    public function test_in_array_rule()
    {
        $rule = new InArrayRule([1, 2, 3, 4, 5, false]);

        $this->assertValid($rule, 3);
        $this->assertValid($rule, false);
        $this->assertValid($rule, '');
        $this->assertValid($rule, null);


        $rule = new InArrayRule([1, 2, 3, 4, 5]);
        $this->assertInValid($rule, 20);
        $this->assertInValid($rule, false);
        $this->assertInValid($rule, null);
        $this->assertInValid($rule, '');
    }
}
