<?php

namespace App\Http\Requests\Api\Site\Blog;

use App\Rules\ImageRule;
use Illuminate\Foundation\Http\FormRequest;

class BlogStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'images' => ['nullable', 'array'],
            'images.*' => ['nullable', new ImageRule()],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:500'],
            'body' => ['required', 'string'],
        ];
    }
}
