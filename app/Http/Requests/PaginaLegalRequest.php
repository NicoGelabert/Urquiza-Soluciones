<?php

namespace App\Http\Requests;

use App\Support\HasTranslations;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaginaLegalRequest extends FormRequest
{
    use HasTranslations;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return array_merge(
            self::translationRule('titulo'),
            self::translationRule('contenido'),
            [
                'slug' => [
                    'required',
                    'string',
                    'max:100',
                    Rule::unique('pagina_legals')->ignore($this->route('legal')),
                ],
            ],
        );
    }
}
