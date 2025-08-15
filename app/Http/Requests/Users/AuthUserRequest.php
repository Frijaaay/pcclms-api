<?php

namespace App\Http\Requests\Users;

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
            'id_number' => ['required', 'string', 'max:11'],
            'password' => ['required', 'string', 'min:8']
        ];
    }
}
