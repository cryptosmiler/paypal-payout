<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use DB;

class StoreLectureRequest extends FormRequest
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

        // Fetch the maximum file size from the database
        $maxFileSize = DB::table('settings')->where('key', 'max_file_size')->value('value');

        // Convert the maximum file size to kilobytes (1 MB = 1024 KB)
        $maxFileSizeKB = $maxFileSize * 1024;

        return [
            'subject_id'    => 'required', 
            'course_id'     => 'required', 
            'video'         => "required|file|mimes:mp4|max:$maxFileSizeKB", 
            'duration'      => 'required|numeric', 
            'title'         => 'required|string|max:250', 
            'description'   => 'required|string|max:250', 
            'size'          => 'required|numeric', 
            'order'         => 'required|numeric', 
        ];
    }

    public function messages()
    {
        return app("messages");
    }
}
