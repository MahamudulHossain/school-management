<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TransportUpdateRequest extends FormRequest
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
        $transport = $this->route('transport');
        return [
            'title' => 'required|unique:transports,title,'.$transport->id,
            'route_info' => 'required',
            'vehicle_info' => 'required',
            'driver_info'=>'required',
            'fare'=>'required|min:1',
        ];
    }
}
