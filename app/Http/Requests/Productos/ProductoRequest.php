<?php

namespace App\Http\Requests\Productos;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductoRequest extends FormRequest
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
            'codigo' => [
                'required', 
                'string', 
                'regex:/^[A-Z]{3}-[0-9]{4}$/',  // Aseguramos que no haya caracteres conflictivos
                Rule::unique('productos', 'codigo')->ignore($this->route('producto'), 'codigo')
            ],
            'nombre' => ['required', 'string', 'max:80'],
            'precio' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'fecha_de_publicacion' => ['required', 'date_format:Y-m-d'],
            'editoriale_id' => ['required', 'string'],
            //'imagen' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048']
        ];
    }
}
