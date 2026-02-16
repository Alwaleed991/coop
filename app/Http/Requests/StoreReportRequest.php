<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
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
            'category'=>['required', 'in:spam,offensive,harassment,misinformation,violence,other'],
            'reason'=> ['required', 'string'],
            'reportable_type'=> ['required', 'in:Post,Comment'],
            'reportable_id'=> ['required']
        ];
    }
}
