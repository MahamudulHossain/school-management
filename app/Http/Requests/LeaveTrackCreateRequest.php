<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeaveTrackCreateRequest extends FormRequest
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
        // dd($this->all());
        return [
            'start_date' => 'required',
            'start_portion' => 'required',
            'end_date' => 'required',
            'end_portion' => 'required',
            'leave_type_id' => 'required',
            'personnel_id' => 'required',
        ];
    }
}
