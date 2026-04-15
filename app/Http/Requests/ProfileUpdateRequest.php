<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
        $profile = $this->route('profile');
        return [
            'gender' => 'required',
            'joining_date' => 'required',
            'nid' => 'nullable|unique:profiles,nid,'. $profile->id,
            'address' => 'required',
        ];
    }
}
