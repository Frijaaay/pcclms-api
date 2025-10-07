<?php

namespace App\Http\Requests;

use App\Exceptions\RequestValidationNotMetException;
use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            'name' => ['string', 'max:100', 'required'],
            'id_number' => ['required', 'string', 'max:11', 'unique:users,id_number', 'regex:/^\d{4}-\d{6}$/'],
            'email' => ['required', 'email', 'max:100', 'unique:users,email', 'regex:/^[a-zA-Z0-9._%+-]+@pcc\.edu\.ph$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.regex' => 'The email must be a valid member of the domain pcc.edu.ph (e.g., 2023-123456@pcc.edu.ph)',
            'email.unique' => 'Email is already taken',
            'id_number.regex' => 'ID Number is invalid',
            'id_number.unique' => 'ID Number is already taken'
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new RequestValidationNotMetException($validator->errors()->first());
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated();

        $plainPassword = Str::random(8);                   // Generate Default Password
        $data['password'] = bcrypt($plainPassword);        // Hash The Password Generated

        $data['status'] = 'Inactive';                       // Default to Inactive
        $data['plain_password'] = $plainPassword;           // Default Plain Password ; Used for email
        $data['user_type_id'] = 3;                          // Default to borrowers only ; Other roles are registered using the superuser
        $data['email_verification_token'] = Str::random(64);

        return $data;
    }
}
