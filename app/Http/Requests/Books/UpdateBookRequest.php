<?php

namespace App\Http\Requests\Books;

use App\Models\Book;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
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
        $routeId = $this->route('id');

        return [
            'title' => ['required', 'string'],
            'author' => ['required', 'string'],
            'author_1' => ['nullable', 'string'],
            'author_2' => ['nullable', 'string'],
            'author_3' => ['nullable', 'string'],
            'isbn' => ['required', 'string', Rule::unique('books', 'isbn')->ignore($routeId, 'id')],
            'category' => ['required', 'string'],
        ];
    }
}
