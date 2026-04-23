<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // “Can this user make this request at all?”	authorize() in FormRequest
        // “Can this user do this action on THIS resource?”	Policy
        // $this refer to the req
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
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:255'],
            'tags' => ['required', 'array'],
            'tags.*' => ['required', 'array'],
            // 'tags.*.id' => ['required', 'integer'], lool sharif if you read this i can not do this rule because the user may create new tag and that tag have no id is the vaildation will fall
            'tags.*.name' => ['required', 'string'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:2048'],
        ];
    }
}
