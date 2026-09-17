<?php

namespace App\Http\Requests;

use App\Support\HasTranslations;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaginaContenidoRequest extends FormRequest
{
    use HasTranslations;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return array_merge(
            self::translationRule('titulo', false),
            self::translationRule('contenido', false),
            [
                'clave' => [
                    'required',
                    'string',
                    'max:100',
                    Rule::unique('pagina_contenidos')->ignore($this->route('contenido')),
                ],
                'datos_extra' => ['nullable', 'array'],
            ],
        );
    }
}
