<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        @if (file_exists(public_path('favicon.ico')))
        <link rel="icon" href="{{ asset('favicon.ico') }}?v={{ filemtime(public_path('favicon.ico')) }}" type="image/x-icon">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v={{ filemtime(public_path('favicon.ico')) }}" type="image/x-icon">
        @endif

        @php
            $googleId = config('analytics.google_id');
            $gtmId = config('analytics.gtm_id');
            $clarityId = config('analytics.clarity_id');
            $hasMeasurement = $googleId || $gtmId || $clarityId;
        @endphp

        @if($hasMeasurement)
        <script>
            window.__ANALYTICS__ = {
                googleId: @json($googleId),
                gtmId: @json($gtmId),
                clarityId: @json($clarityId),
            };
        </script>
        @endif

        @if($googleId || $gtmId)
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('consent', 'default', {
                analytics_storage: 'denied',
                ad_storage: 'denied',
                ad_user_data: 'denied',
                ad_personalization: 'denied',
                wait_for_update: 500,
            });
        </script>
        @endif

        @if($gtmId)
        <script>
            (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});
            var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';
            j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','{{ $gtmId }}');
        </script>
        @elseif($googleId)
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $googleId }}"></script>
        <script>
            gtag('js', new Date());
            gtag('config', '{{ $googleId }}', { send_page_view: false });
        </script>
        @endif

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" />

        @routes
        @vite(['resources/js/app.ts', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased text-brand-950">
        @if($gtmId ?? false)
        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id={{ $gtmId }}" height="0" width="0" style="display:none;visibility:hidden"></iframe>
        </noscript>
        @endif
        @inertia
    </body>
</html>
