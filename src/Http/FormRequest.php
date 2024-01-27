<?php

namespace Mailer\Http;

use Mailer\Contracts\Rule;

class FormRequest extends Request
{
    /**
     * @param Request $httpRequest
     *
     * @return static
     */
    public function copyFromRequest(Request $httpRequest): static
    {
        $this->setQuery($httpRequest->query());
        $this->setPost($httpRequest->post());
        $this->setFiles($httpRequest->file());
        $this->setServerConfigs($httpRequest->server());
        $this->setPaths($httpRequest->path());

        return $this;
    }

    /**
     * @return array
     */
    public function validate(): array
    {
        $messages = [];
        $rules    = $this->rules();

        foreach ($rules as $key => $fieldRules) {
            foreach ($fieldRules as $rule) {
                if (is_string($rule)) {
                    $rule = new $rule;
                }

                /** @var Rule $rule */
                $rule->setFieldName($key);
                $rule->setValue($this->post($key));

                if (!$rule->validate()) {
                    $messages[$key][] = $rule->message();
                }
            }
        }

        return $messages;
    }

    /**
     * @return array
     */
    protected function rules(): array
    {
        return [];
    }
}
