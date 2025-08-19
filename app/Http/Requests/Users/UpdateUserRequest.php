<?php

namespace App\Http\Requests\Users;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
    */
    public function authorize(): bool
    {
        $userId = $this->route('id');

        $updatedUser = User::findOrFail($userId);

        return $this->user()->can('updateUser', $updatedUser);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $routeId = $this->route('id');

        return [
            'user_type_id' => ['required', 'integer', 'in:1,2,3'],
            'id_number' => ['required', 'string', Rule::unique('users', 'id_number')->ignore($routeId, 'id'), 'regex:/^20\d{2}-\d{6}$/'],
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', Rule::unique('users', 'email')->ignore($routeId, 'id'), 'regex:/^[a-zA-Z0-9._%+-]+@pcc\.edu\.ph$/'],
            'type' => ['required', 'string', 'max:100'],
            'department' => ['required', 'string', 'max:100']
        ];
    }

    public function messages(): array
    {
        return [
            'id_number.regex' => 'The ID No format is incorrect or not valid (e.g. 2025-123456)',
            'email.regex' => 'The email must be a valid member of the domain pcc.edu.ph (e.g., 2025-123456@pcc.edu.ph)'
        ];
    }
}
