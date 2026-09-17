<?php

namespace App\Http\Middleware;

use App\Models\Configuracion;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        $locale = app()->getLocale();

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'locale' => $locale,
            'locales' => config('site.locales', ['es', 'en']),
            'site' => [
                'name' => config('site.name'),
                'telefono' => Configuracion::get('telefono'),
                'whatsapp' => Configuracion::get('whatsapp'),
                'instagram' => Configuracion::get('instagram'),
                'email' => Configuracion::get('email'),
                'telefono_urgencias' => Configuracion::get('telefono_urgencias'),
            ],
            'analytics' => [
                'google_id' => config('analytics.google_id'),
                'clarity_id' => config('analytics.clarity_id'),
                'enabled' => (bool) (config('analytics.google_id') || config('analytics.clarity_id')),
            ],
            'recaptcha' => [
                'site_key' => config('recaptcha.site_key'),
                'enabled' => (bool) config('recaptcha.site_key'),
            ],
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
            ],
        ];
    }
}
