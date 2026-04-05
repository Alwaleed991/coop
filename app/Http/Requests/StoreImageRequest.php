<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreImageRequest extends FormRequest
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
            "images" => ['required', 'array'],
            'images.*' => ['image', 'max:2048']
        ];
    }
}


// **FormData request:**
// {
//     images[] → file1
//     images[] → file2
//     images[] → file3
// }

// what laravel sees
// [
//     "images" => [file1, file2, file3]
// ]