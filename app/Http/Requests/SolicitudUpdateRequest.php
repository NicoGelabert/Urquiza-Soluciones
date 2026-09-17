<?php

namespace App\Http\Requests;

use App\Enums\SolicitudEstado;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SolicitudUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'estado' => ['required', Rule::enum(SolicitudEstado::class)],
            'notas_admin' => ['nullable', 'string', 'max:5000'],
        ];
    }
}
