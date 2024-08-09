<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLandingItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->guard('admin')->user()->role === "SuperAdmin";
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'         => "required|string|max:255|min:5", 
            'description'   => "required|string|min:10", 
            // 'file'          => "required|file|mimes:mp4", 
            'order'         => "required|numeric"
        ];
    }

    public function messages()
    {
        return app("messages");
    }
}
