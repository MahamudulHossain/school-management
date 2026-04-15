<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'name' => 'required',
            'cell_phone' => 'required_without_all:email|nullable|regex:/(01)[0-9]{9}/|unique:users',
            'email' => 'required_without_all:cell_phone|nullable|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'user_type' => 'required'
        ];
    }
}
