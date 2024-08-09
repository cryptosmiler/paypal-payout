<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionRequest extends FormRequest
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
            'subject_id'    => "required", 
            'course_id'     => "required", 
            'lecture_id'    => "required", 
            'question'      => 'required|string|max:255|min:5', 
            'answer'        => 'required|array', 
            'difficulty'    => 'required|string'
        ];
    }

    public function messages()
    {
        return app("messages");
    }
}
