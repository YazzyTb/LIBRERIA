<?php

namespace App\Http\Requests\Clientes;

use App\Models\Cliente;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClienteRequest extends FormRequest
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
        $ci = $this->ci;
        return [
            'ci' => ['required', 'numeric',  Rule::unique('clientes', 'ci')->ignore($this->route('cliente'), 'ci')],
            'nombre' => 'required|string|max:50',
            'puntos' => 'required|int|max:100',
        ];
    }
}
