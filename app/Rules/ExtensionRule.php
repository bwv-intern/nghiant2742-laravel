<?php

namespace App\Rules;

use App\Utils\MessageUtil;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ExtensionRule implements ValidationRule
{
    public $ext;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($ext)
    {
        //
        $this->ext = $ext;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $extension = $value->getClientOriginalExtension();
        $validExtension = $extension === $this->ext;
        if (!$validExtension) {
            $fail(MessageUtil::getMessage('errors', 'E007', [$this->ext]) );
        }
    }
}
