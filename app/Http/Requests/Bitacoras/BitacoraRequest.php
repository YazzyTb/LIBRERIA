<?php

namespace App\Http\Requests\Bitacoras;

use Illuminate\Foundation\Http\FormRequest;

class BitacoraRequest extends FormRequest
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
            'tabla_afectada' => ['required', 'string', 'max:20'],
            //'accione_id' => ['required', 'numeric', 'exists:acciones,id'],
            'user_id' => ['required', 'numeric', 'exists:users,id'],
            'fecha_hora' => ['required', 'date_format:Y-m-d H:i:s', 'max:20'],
            'datos_anteriores' => ['nullable', 'string'],
            'datos_nuevos' => ['nullable', 'string'],
            'ip_address' => ['required', 'ip'],
        ];
    }
}
