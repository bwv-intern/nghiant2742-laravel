<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Utils\MessageUtil;

class LoginRequest extends FormRequest
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
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        $errorMsg001 = MessageUtil::getMessage('E001', ['Email']);
        $errorMsg004 = MessageUtil::getMessage('E004');

        return [
            'email.required' => str_replace('{0}', 'Email', $errorMsg001),
            'email.email' => $errorMsg004,
            'password.required' => str_replace('{0}', 'Password', $errorMsg001),
        ];
    }
}
