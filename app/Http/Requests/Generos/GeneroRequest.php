<?php

namespace App\Http\Requests\Generos;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GeneroRequest extends FormRequest
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
            'id' => ['nullable', 'numeric', Rule::unique('generos', 'id')->ignore($this->id)],
            'nombre' => ['required', 'string', 'max:20'],
            'descripcion' => ['required', 'string', 'max:500'],
        ];
    }
}
