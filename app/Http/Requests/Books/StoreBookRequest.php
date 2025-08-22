<?php

namespace App\Http\Requests\Books;

use App\Models\Book;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'author' => ['required', 'string'],
            'author_1' => ['nullable', 'string'],
            'author_2' => ['nullable', 'string'],
            'author_3' => ['nullable', 'string'],
            'isbn' => ['required', 'string', 'unique:books,isbn'],
            'category' => ['required', 'string'],
            'book_copies_count' => ['nullable', 'integer']
        ];
    }

    public function messages(): array
    {
        return [
            'isbn.unique' => 'Item already exists'
        ];
    }
}
