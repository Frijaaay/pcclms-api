<?php

namespace App\Http\Requests\Users;

use App\Exceptions\RequestValidationNotMetException;
use Illuminate\Foundation\Http\FormRequest;

class AuthUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    /**
     * Prepares the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'id_number' => trim($this->id_number)  // This removes whitespaces
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_number' => ['required', 'string', 'regex:/^20\d{2}-\d{6}$/'],
            'password' => ['required', 'string', 'min:8']
        ];
    }
    public function messages(): array
    {
        return [
            'id_number.regex' => 'ID number is not valid',
            'password.min' => 'Invalid password',
        ];
    }

    /**
     * Handles a failed validation.
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new RequestValidationNotMetException($validator->errors()->first());
    }
}
