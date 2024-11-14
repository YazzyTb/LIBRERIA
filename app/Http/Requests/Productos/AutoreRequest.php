<?php

namespace App\Http\Requests\Productos;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AutoreRequest extends FormRequest
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
            'nombre' => ['required', 'string', Rule::unique('autores', 'nombre')->ignore($this->route('autor'), 'id')],
        ];
    }
}
