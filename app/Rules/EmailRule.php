<?php

namespace App\Rules;

use App\Utils\MessageUtil;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EmailRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $validEmail = preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $value);
        if (!$validEmail) {
            $fail(MessageUtil::getMessage('errors', 'E004') );
        }
    }
}