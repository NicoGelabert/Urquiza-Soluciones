<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class Recaptcha implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $secret = config('recaptcha.secret_key');

        if (! $secret) {
            return;
        }

        if (! is_string($value) || $value === '') {
            $fail(__('messages.recaptcha_failed'));

            return;
        }

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secret,
            'response' => $value,
            'remoteip' => request()->ip(),
        ]);

        $body = $response->json();

        if (! ($body['success'] ?? false)) {
            $fail(__('messages.recaptcha_failed'));

            return;
        }

        $minScore = config('recaptcha.min_score', 0.5);

        if (($body['score'] ?? 0) < $minScore) {
            $fail(__('messages.recaptcha_failed'));
        }
    }
}
