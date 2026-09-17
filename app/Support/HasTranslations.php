<?php

namespace App\Support;

trait HasTranslations
{
    public function translate(string $field, ?string $locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();
        $value = $this->{$field};

        if (! is_array($value)) {
            return $value;
        }

        return $value[$locale] ?? $value['es'] ?? null;
    }

    public static function translationRule(string $field, bool $required = true): array
    {
        $rules = [
            "{$field}.es" => ($required ? 'required' : 'nullable').'|string',
            "{$field}.en" => 'nullable|string',
        ];

        return $rules;
    }
}
