<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
        // dd(request()->all());
        // Safely get the ID whether it's a bound Model or a raw integer
        $userParam = $this->route('user');
        $id = is_object($userParam) ? $userParam->id : $userParam;

        return [
            'name' => ['nullable', 'string', 'max:255'],

            'cell_phone' => [
                'required_without:email',
                'nullable',
                'regex:/(01)[0-9]{9}/',
                Rule::unique('users', 'cell_phone')->ignore($id),
            ],

            'email' => [
                'required_without:cell_phone',
                'nullable',
                'email',
                Rule::unique('users', 'email')->ignore($id),
            ],

            'password' => [
                'nullable',
                'string',
                'min:6',
                'confirmed' // Automatically expects 'password_confirmation' to match
            ],
        ];
    }
}
