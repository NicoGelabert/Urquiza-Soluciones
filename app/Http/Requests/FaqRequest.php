<?php

namespace App\Http\Requests;

use App\Support\HasTranslations;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FaqRequest extends FormRequest
{
    use HasTranslations;

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('servicio_id') && $this->servicio_id === '') {
            $this->merge(['servicio_id' => null]);
        }
    }

    public function rules(): array
    {
        return array_merge(
            self::translationRule('pregunta'),
            self::translationRule('respuesta'),
            [
                'servicio_id' => ['nullable', 'exists:servicios,id'],
                'orden' => ['nullable', 'integer', 'min:0'],
                'activo' => ['nullable', 'boolean'],
            ],
        );
    }
}
