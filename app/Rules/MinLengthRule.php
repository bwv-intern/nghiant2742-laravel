<?php

namespace App\Rules;

use App\Utils\MessageUtil;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MinLengthRule implements ValidationRule
{
    public $currNumber;
    public $maxNumber;

    public $attribute;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($maxNumber, $attribute = ':attribute')
    {
        //
        $this->currNumber = 0;
        $this->maxNumber = $maxNumber;
        $this->attribute = $attribute;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $this->currNumber = mb_strlen($value);
        $isLarger = $this->currNumber >= $this->maxNumber;

        if(!$isLarger){
            $fail(MessageUtil::getMessage('errors', 'E003', [ucfirst($attribute), $this->maxNumber, $this->currNumber]) );
        }
    }


}
