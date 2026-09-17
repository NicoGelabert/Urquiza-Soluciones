<?php

namespace App\Http\Requests;

use App\Support\HasTranslations;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServicioRequest extends FormRequest
{
    use HasTranslations;

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $jsonFields = ['titulo', 'hero_subtitulo', 'descripcion_corta', 'descripcion_larga', 'meta_title', 'meta_description'];

        foreach ($jsonFields as $field) {
            if ($this->has($field) && is_string($this->$field)) {
                $this->merge([$field => json_decode($this->$field, true) ?? []]);
            }
        }

        if ($this->has('items') && is_string($this->items)) {
            $this->merge(['items' => json_decode($this->items, true) ?? []]);
        }

        if ($this->has('activo')) {
            $this->merge(['activo' => filter_var($this->activo, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? $this->activo]);
        }

        if ($this->has('icono') && $this->icono === '') {
            $this->merge(['icono' => null]);
        }
    }

    public function rules(): array
    {
        $servicioId = $this->route('servicio')?->id;

        return array_merge(
            self::translationRule('titulo'),
            self::translationRule('hero_subtitulo', false),
            self::translationRule('descripcion_corta'),
            self::translationRule('descripcion_larga'),
            self::translationRule('meta_title', false),
            self::translationRule('meta_description', false),
            [
                'slug' => ['required', 'string', 'max:100', Rule::unique('servicios')->ignore($servicioId)],
                'slug_en' => ['required', 'string', 'max:100', Rule::unique('servicios', 'slug_en')->ignore($servicioId)],
                'icono' => ['nullable', 'string', 'max:50', Rule::in(array_keys(config('service_icons.icons')))],
                'orden' => ['nullable', 'integer', 'min:0'],
                'activo' => ['nullable', 'boolean'],
                'imagen_cabecera' => ['nullable', 'image', 'max:5120'],
                'items' => ['nullable', 'array'],
                'items.*.titulo' => ['required', 'array'],
                'items.*.titulo.es' => ['required', 'string'],
                'items.*.titulo.en' => ['nullable', 'string'],
                'items.*.descripcion' => ['nullable', 'array'],
                'items.*.orden' => ['nullable', 'integer'],
            ],
        );
    }
}
