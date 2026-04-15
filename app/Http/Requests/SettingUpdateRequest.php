<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingUpdateRequest extends FormRequest
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
            'org_name' => 'required',
            'address_line1' => 'required',
            'contact_no1' => 'required|regex:/(01)[0-9]{9}/',
            'email' => 'nullable|email',
            'web' => 'nullable|url',
            'price_formats' => 'required',
            'country_id' => 'required|exists:countries,id',
        ];
    }
}
