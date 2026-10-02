<?php

return [
    /** GA4 measurement ID (G-…). Omit if GA4 se sirve solo desde GTM. */
    'google_id' => env('GOOGLE_ANALYTICS_ID'),

    /** Google Tag Manager container (GTM-…). Recomendado para Google Ads + GA4. */
    'gtm_id' => env('GOOGLE_TAG_MANAGER_ID'),

    'clarity_id' => env('CLARITY_PROJECT_ID'),
];
