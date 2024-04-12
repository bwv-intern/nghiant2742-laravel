<?php

namespace App\Http\Requests;

use App\Rules\ExtensionRule;
use App\Utils\MessageUtil;
use Illuminate\Foundation\Http\FormRequest;

class ImportRequest extends FormRequest
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
            'csv_file' => ['required', new ExtensionRule('csv'), 'max:5000']
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array {
        return [
            'csv_file.required' => MessageUtil::getMessage('errors', 'E001', ['File']),
            'csv_file.max' => MessageUtil::getMessage('errors', 'E006', ['5MB']),
        ];
    }
}
