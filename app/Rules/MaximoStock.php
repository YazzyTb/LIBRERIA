<?php

namespace App\Rules;

use App\Models\Stock;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MaximoStock implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    protected $producto_codigo;

    public function __construct($producto_codigo)
    {
        $this->producto_codigo = $producto_codigo;
    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $stock = Stock::where('codigo', $this->producto_codigo)->first();

        // Verifica si la cantidad excede el stock disponible
        if ($stock && $value > $stock->cantidad) {
            $fail("La cantidad solicitada para el producto {$this->producto_codigo} excede el stock disponible.");
        }
    }
}
