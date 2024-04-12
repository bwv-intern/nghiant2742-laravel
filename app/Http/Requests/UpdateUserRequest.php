<?php

namespace App\Http\Requests;

use App\Rules\EmailRule;
use App\Rules\MaxLengthRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Utils\MessageUtil;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Get ID
        $id = $this->segment(3);
        $uniqueEmail = 'unique:users,email,' . $id;
        
        $rules = [
            'email' =>  ['required', new EmailRule, new MaxLengthRule(50), $uniqueEmail ],
            'name' =>  ['required', new MaxLengthRule(50)],
            'user_flg' => 'required',
            'phone' =>  ['nullable','numeric', new MaxLengthRule(20)],
            'address' => ['nullable'],
            'date_of_birth' => 'nullable|date_format:Y-m-d',
        ];

        // If password sent, add rules
        if ($this->filled('password') || $this->filled('re_password')) {
            $rules['password'] = ['required', 'same:re_password'];
            $rules['re_password'] = 'required';
        }
    
        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array {
        return [
            'name.required' => MessageUtil::getMessage('errors', 'E001', ['Name']),
            'email.required' => MessageUtil::getMessage('errors', 'E001', ['Email']),
            'email.email' => MessageUtil::getMessage('errors', 'E004'),
            'email.unique' => MessageUtil::getMessage('errors', 'E009', ['Email']),
            'password.required' => MessageUtil::getMessage('errors', 'E001', ['Password']),
            'password.same' => MessageUtil::getMessage('errors', 'E011'),
            're_password.required' => MessageUtil::getMessage('errors', 'E011', ['Re-password']),
            'phone.numeric' => MessageUtil::getMessage('errors', 'E012', ['Phone','number']),
            'date_of_birth.date_format' => MessageUtil::getMessage('errors', 'E012', ['Date','Y-m-d']),
        ];
    }
}
