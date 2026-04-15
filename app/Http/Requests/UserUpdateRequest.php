<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        $userId = $this->route('user');

        $rules = [
            'name' => 'required',
            'cell_phone' => 'required_without_all:email|nullable|regex:/(01)[0-9]{9}/|unique:users,cell_phone,' . $userId->id,
            'email' => 'required_without_all:cell_phone|nullable|email|unique:users,email,' . $userId->id,
        ];

        if (!empty($this->password) && $this->password !== null) {
            $rules['password'] = 'min:6|same:password_confirmation';
        }

        return $rules;
    }
}
