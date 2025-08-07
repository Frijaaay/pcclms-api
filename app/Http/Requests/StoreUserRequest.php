<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'user_type_id' => ['required', 'string', 'max:10'],
            'id_number' => ['required', 'string', 'max:11', 'unique:users,id_number', 'regex:/^20\d{2}-\d{6}$/'],
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:users,email', 'regex:/^[a-zA-Z0-9._%+-]+@pcc\.edu\.ph$/'],
            'type' => ['required', 'string', 'max:100'],
            'department' => ['required', 'string', 'max:100']
        ];
    }

    /**
     * Custom Messages
     */
    public function messages(): array
    {
        return [
            'email.regex' => 'The email must be a valid member of the domain pcc.edu.ph (e.g., 2023-123456@pcc.edu.ph)'
        ];
    }

    /**
     * Sets Auto Filled Values
     */
    public function validated($key = null, $default = null)
    {
        $data = parent::validated();

        $plainPassword = Str::random(8);                   // Generate Default Password
        $data['password'] = bcrypt($plainPassword);        // Hash The Password Generated

        match ($data['user_type_id']) {
            'admin' => $data['user_type_id'] = 1,
            'librarian' => $data['user_type_id'] = 2,
            'borrower' => $data['user_type_id'] = 3,
            // default => $data['user_type_id'] = 3, // Default to Borrower
        };

        $data['status'] = 'Inactive';                       // Default to Inactive
        $data['plain_password'] = $plainPassword;           // Default Plain Password ; Used for email

        return $data;
    }
}
