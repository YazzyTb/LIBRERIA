<?php

namespace App\Http\Requests\Productos;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LibroRequest extends FormRequest
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
            'producto_codigo' => ['required', 'string', 'exists:productos,codigo', 
            Rule::unique('libros', 'producto_codigo')->ignore($this->route('libro'), 'producto_codigo')],
            'edicion' => ['required', 'integer'],
            'tipo_de_tapa' => ['required', 'string'],
            'autores_nombre' => ['required', 'array'],
            'autores_nombre*' => ['string', 'distinct']
        ];
    }
}
