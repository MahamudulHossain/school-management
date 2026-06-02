<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Illuminate\Validation\Rule;

class UserCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Normalize inputs so keys always exist (prevents undefined index issues).
     */
    protected function prepareForValidation(): void
    {
        if ((int) $this->input('user_type') === 2) {
            $this->merge([
                'guardian_id'         => $this->input('guardian_id', null),
                'guardian_email'      => $this->input('guardian_email', null),
                'guardian_cell_phone' => $this->input('guardian_cell_phone', null),
            ]);
        }
    }

    public function rules(): array
    {
        // Teacher / Employee
        if (in_array((int) $this->input('user_type'), [3, 4], true)) {
            return [
                'cell_phone' => [
                    'nullable',
                    'regex:/^\+\d{13}$/',
                    'unique:users,cell_phone',
                    Rule::requiredIf(!$this->filled('email')),
                ],
                'email' => [
                    'nullable',
                    'email',
                    'unique:users,email',
                    Rule::requiredIf(!$this->filled('cell_phone')),
                ],
                'password'    => 'required|min:6',
                'roles'       => 'required|array',
                'roles.*'     => 'required|exists:roles,id',
                'joining_date'=> 'required|date',
            ];
        }

        // Student
        if ((int) $this->input('user_type') === 2) {
            return [
                'first_name'    => 'required',
                'roles'         => 'required|array',
                'roles.*'       => 'required|exists:roles,id',
                'joining_date'  => 'required|date',

                // At least one is required (ID, Email, or Phone)
                'guardian_id' => [
                    'nullable',
                    'exists:guardians,id',
                    'required_without_all:guardian_email,guardian_cell_phone',
                ],
                'guardian_email' => [
                    'nullable',
                    'email',
                    'unique:users,email',
                    'required_without_all:guardian_id,guardian_cell_phone',
                ],
                'guardian_cell_phone' => [
                    'nullable',
                    'regex:/^\+\d{13}$/',
                    'unique:users,cell_phone',
                    'required_without_all:guardian_id,guardian_email',
                ],

                'gender'           => 'required',
                'roll'             => 'required',
                'school_class_id'  => 'required',
                'school_section_id'=> 'required',
                'academic_year_id' => 'required',
            ];
        }

        // Default
        return [
            'name'       => 'required',
            'cell_phone' => [
                'nullable',
                'regex:/^\+\d{13}$/',
                'unique:users,cell_phone',
                Rule::requiredIf(!$this->filled('email')),
            ],
            'email'      => [
                'nullable',
                'email',
                'unique:users,email',
                Rule::requiredIf(!$this->filled('cell_phone')),
            ],
            'password' => 'required|min:6|confirmed',
            'user_type' => 'required',
        ];
    }

    /**
     * Enforce "exactly one of" the guardian fields for students.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ((int) $this->input('user_type') !== 2) {
                return;
            }

            $fields = ['guardian_id', 'guardian_email', 'guardian_cell_phone'];

            // Count how many are filled (no raw PHP variables!)
            $filled = collect($fields)->filter(fn ($f) => $this->filled($f))->count();

            if ($filled > 1) {
                foreach ($fields as $f) {
                    $validator->errors()->add(
                        $f,
                        'Only one of Guardian ID, Guardian Email, or Guardian Phone may be provided.'
                    );
                }
            }
        });
    }
}
