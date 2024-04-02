<?php

namespace App\Http\Requests;

use App\Rules\MaxLengthRule;
use App\Rules\MinLengthRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Utils\MessageUtil;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'email' =>  ['required','email', new MaxLengthRule(75),'unique:users,email'],
            'name' =>  ['required', new MaxLengthRule(50)],
            'password' => ['required', new MinLengthRule(6) , new MaxLengthRule(100), 'same:re_password'],
            're_password' => 'required',
            'user_flg' => 'required',
            'phone' =>  ['nullable','numeric', new MaxLengthRule(11)],
            'address' => ['nullable',new MaxLengthRule(255)],
            'dateOfBirth' => 'nullable|date_format:Y-m-d',
        ];
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
            're_password.required' => MessageUtil::getMessage('errors', 'E011', ['Password']),
            'phone.numeric' => MessageUtil::getMessage('errors', 'E012', ['Phone','number']),
            'dateOfBirth.date_format' => MessageUtil::getMessage('errors', 'E012', ['Date','Y-m-d']),
        ];
    }
}