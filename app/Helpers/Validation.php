<?php

namespace App\Helpers;

class Validation
{
    private $errors = [];
    private $data = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function validate(array $rules)
    {
        foreach ($rules as $field => $rule) {
            $rulesArray = explode('|', $rule);

            foreach ($rulesArray as $singleRule) {
                $this->applyRule($field, $singleRule);
            }
        }

        return $this;
    }

    private function applyRule($field, $rule)
    {
        $value = $this->data[$field] ?? null;

        // Rule with parameter, e.g., min:6
        if (strpos($rule, ':') !== false) {
            list($ruleName, $param) = explode(':', $rule, 2);
        } else {
            $ruleName = $rule;
            $param = null;
        }

        switch ($ruleName) {
            case 'required':
                if (empty($value)) {
                    $this->addError($field, "فیلد {$field} الزامی است.");
                }
                break;
            case 'email':
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($field, "ایمیل وارد شده معتبر نیست.");
                }
                break;
            case 'min':
                if (strlen($value) < $param) {
                    $this->addError($field, "فیلد {$field} باید حداقل {$param} کاراکتر باشد.");
                }
                break;
            case 'max':
                if (strlen($value) > $param) {
                    $this->addError($field, "فیلد {$field} باید حداکثر {$param} کاراکتر باشد.");
                }
                break;
            case 'confirmed':
                if ($value !== ($this->data[$field . '_confirmation'] ?? null)) {
                    $this->addError($field, "فیلد {$field} با تاییدیه آن مطابقت ندارد.");
                }
                break;
        }
    }

    public function addError($field, $message)
    {
        $this->errors[$field][] = $message;
    }

    public function fails()
    {
        return !empty($this->errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
