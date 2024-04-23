<?php

namespace App\Rules;

use App\Models\User;
use App\Utils\MessageUtil;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UserIdExistsRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value != "") {
            $user = User::find($value);
            if (!$user) {              
                $fail(MessageUtil::getMessage('errors', 'E015', ['User ID']) );
            }
        }
    }
}
