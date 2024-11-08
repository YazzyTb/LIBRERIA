<?php

namespace App\Http\Requests\Acciones;

use Illuminate\Foundation\Http\FormRequest;

class AccioneRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'operacion' => ['required', 'string', 'max:10'],
            'descripcion' => ['required', 'string', 'max:500'],
        ];
    }
}
