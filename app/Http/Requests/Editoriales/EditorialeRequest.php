<?php

namespace App\Http\Requests\Editoriales;

use App\Models\Editoriale;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditorialeRequest extends FormRequest
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
            'nombre' => ['required', 'string', 'max:50', Rule::unique(Editoriale::class)->ignore($this->id)],
        ];
    }
}
