<?php

namespace App\Http\Requests\Transaccion;

use App\Rules\MaximoStock;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class VentaRequest extends FormRequest
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
            'productos_array' => ['required', 'array'],
            'productos_array.*' => ['string', 'distinct', 'exists:productos,codigo'],
            'cantidad_array' => ['required', 'array'],
            'cantidad_array.*' => ['integer'],
            'cliente_ci' => ['nullable', 'exists:clientes,ci'],
        ];
    }

    /**
     * Configurar validaciones adicionales después de las reglas iniciales.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            // Validar que cada cantidad esté dentro del stock disponible para el producto
            foreach ($this->productos_array as $index => $producto_codigo) {
                // Aplica la regla MaximoStock a cada elemento de cantidad_array
                $validator->addRules([
                    "cantidad_array.$index" => [new MaximoStock($producto_codigo)],
                ]);
            }
        });
    }
}
