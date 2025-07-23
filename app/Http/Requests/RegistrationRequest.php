<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
            'user_type_id' => ['required', 'integer', 'max:1', 'exists:user_types,id'],
            'id_no' => ['required', 'string', 'max:11', 'unique:users,id_number'],
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email:filter'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }
}
