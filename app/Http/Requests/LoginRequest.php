<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\Yaml\Yaml;

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
        $yamlPath = file_get_contents('../messages.yaml');
        $yamlContents = Yaml::parse($yamlPath);
        

        return [
            'email.required' => str_replace('{0}', 'Email', $yamlContents['errors']['E001']),
            'email.email' => $yamlContents['errors']['E004'],
            'password.required' => str_replace('{0}', 'Password', $yamlContents['errors']['E001']),
        ];
    }
}
