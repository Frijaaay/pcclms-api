<?php

namespace App\Http\Requests\Users;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        // New user instance from request
        $newUser = new User(['user_type_id' => (int) $this->input('user_type_id')]);

        // Calls the policy
        return $this->user()->can('storeUser', $newUser);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_type_id' => ['required', 'integer', 'in:1,2,3'],
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

        $data['status'] = 'Inactive';                       // Default to Inactive
        $data['plain_password'] = $plainPassword;           // Default Plain Password ; Used for email

        $data['email_verification_token'] = Str::random(64);

        return $data;
    }
}
