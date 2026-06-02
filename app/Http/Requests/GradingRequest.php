<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GradingRequest extends FormRequest
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
            'letter_grade' => 'required',
            'grade_point' => 'required',
            'starting_marks' => 'required',
            'ending_marks'=>'required|gt:starting_marks',
        ];
    }
}
