<?php

namespace App\Http\Requests\Empleados;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmpleadoRequest extends FormRequest
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
            'id_anterior' => ['required', 'numeric', 'exists:users,id'],
            'id' => ['nullable', 'numeric',  Rule::unique(User::class)->ignore($this->user()->id)],
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'role_id' => ['nullable', 'string', 'exists:roles,nombre']
        ];
    }
}
