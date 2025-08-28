<?php

namespace App\Http\Requests;

use App\Models\Book;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBookCopyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('manage_book', Book::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'condition' => ['required', 'string', 'in:Good,Slightly Damaged,Severely Damaged,Lost'],
            'status' => ['required', 'string', 'in:Available,Unavailable']
        ];
    }
}
